<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProcedureResource;
use App\Models\ActionFile;
use App\Models\Derivation;
use App\Models\File;
use App\Models\LegalPerson;
use App\Models\LegalRepresentative;
use App\Models\Office;
use App\Models\Person;
use App\Models\Procedure;
use App\Models\ProcedureState;
use App\Models\Resolution;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProceduresOfficeController extends Controller
{
    public function index()
    {
        $userOfficeId = auth()->user()->office->id; // u office_id si tienes la FK directamente

        $offices = Office::where('id', '!=', $userOfficeId)->get();

        $resolutions = Resolution::select('id', 'resolution_number', 'description', 'resolution_type_id')
            ->with('resolution_type')->get();

        return view('admin.procedures-office.index', compact('offices', 'resolutions'));
    }

    public function data()
    {
        $user = Auth::user();

        $query = Derivation::query()
            ->with([
                'procedure.applicant' => function ($morphTo) {
                    $morphTo->morphWith([
                        Person::class => ['identity_type:id,name'],
                        LegalRepresentative::class => ['person:id,name,last_name,second_last_name,email,identity_number,identity_type_id', 'person.identity_type:id,name', 'legal_person:id,company_name,ruc'],
                        User::class => ['person:id,name,last_name,second_last_name,email,identity_number,identity_type_id', 'person.identity_type:id,name'],
                    ]);
                },
                'procedure.state',
                'procedure.category',
                'procedure.priority',
                'procedure.document_type'
            ])
            ->where('is_active', true)
            ->where('user_id', $user->id);

        return DataTables::eloquent($query)
            ->addColumn('expedient_number', fn($d) => $d->procedure->expedient_number)
            ->addColumn('reason', fn($d) => $d->procedure->reason)
            ->addColumn('applicant_name', function ($d) {
                $applicant = $this->getApplicantData($d->procedure);
                return collect($applicant)['name'];
            })
            ->addColumn('applicant_email', function ($d) {
                $applicant = $this->getApplicantData($d->procedure);
                return collect($applicant)['email'];
            })
            ->addColumn('applicant_identity', function ($d) {
                $applicant = $this->getApplicantData($d->procedure);
                return collect($applicant)['identityNumber'];
            })
            ->addColumn('document_type', fn($d) => $d->procedure->document_type->name ?? '')
            ->addColumn('procedure_category', fn($d) => $d->procedure->category->name ?? '')
            ->addColumn('procedure_priority', fn($d) => $d->procedure->priority->name ?? '')
            ->addColumn('procedure_state', fn($d) => $d->procedure->state->name ?? '')
            ->addColumn('actions', fn() => '')

            ->rawColumns(['actions'])
            ->toJson();
    }

    public function getApplicantData($procedure)
    {
        $procedureApplicant = $procedure->applicant;
        $applicant = [];
        if ($procedureApplicant instanceof Person) {
            $person = $procedureApplicant;
            $applicant['email'] = $person->email;
        } elseif ($procedureApplicant instanceof LegalRepresentative) {
            $person = $procedureApplicant->person;
            $applicant['email'] = $person->email;
        } elseif ($procedureApplicant instanceof User) {
            $person = $procedureApplicant->person;
            $applicant['email'] = $procedureApplicant->email; // el correo será tomado del usuario
        }
        $applicant['name'] = $person->full_name;
        $applicant['identityNumber'] = $person->identity_number;
        return $applicant;
    }

    public function info_procedure(Request $request)
    {
        $request->validate([
            'procedure_id' => 'required|integer',
        ]);

        $procedure = Procedure::with([
            'state',
            'category',
            'priority',
            'document_type',
            'procedure_files',
            'procedure_link',
            'actions.action_files',
            'applicant' => function ($morphTo) {
                $morphTo->morphWith([
                    Person::class => ['identity_type:id,name'],
                    LegalRepresentative::class => ['person:id,name,last_name,second_last_name,email,identity_number,identity_type_id', 'person.identity_type:id,name', 'legal_person:id,company_name,ruc'],
                    User::class => ['person:id,name,last_name,second_last_name,email,identity_number,identity_type_id', 'person.identity_type:id,name'],
                ]);
            },
        ])->find($request->procedure_id);

        if (!$procedure) {
            return response()->json(['success' => false, 'message' => 'Procedimiento no encontrado'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new ProcedureResource($procedure)
        ]);
    }

    public function generate_expedient_number()
    {
        $year = now()->year;

        // Obtener todos los procedimientos del año actual
        $procedures = Procedure::whereYear('created_at', $year)
            ->whereNotNull('expedient_number')
            ->get();

        $maxNumber = 0;

        // Iterar y encontrar el valor numérico más alto
        foreach ($procedures as $procedure) {
            if (preg_match('/EXP-(\d+)-' . $year . '/', $procedure->expedient_number, $matches)) {
                $currentNumber = (int) $matches[1];
                if ($currentNumber > $maxNumber) {
                    $maxNumber = $currentNumber;
                }
            }
        }

        // El próximo número será el máximo + 1
        $nextNumber = $maxNumber + 1;

        $expedientNumber = 'EXP-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT) . '-' . $year;

        return response()->json([
            'success' => true,
            'data' => $expedientNumber
        ]);
    }

    public function users_office(Request $request)
    {
        $office = Office::findOrFail($request->office_id);
        $users = $office->users()->with('person')->select('users.id', 'person_id')->get();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Process and save an action related to a derivation
     * 
     * This function handles different types of actions: comment, derive, conclude, cancel or archive.
     * It creates the action record, handles file uploads, updates derivation status, and updates procedure state.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save_action(Request $request)
    {
        // Validate the basic request data
        $request->validate([
            'derivation_id' => 'required|integer|exists:derivations,id',
            'comment' => 'nullable|string|max:500',
            'file' => 'nullable|file|max:10240|mimes:pdf,jpg,png',
            'resolution_id' => 'nullable|integer|exists:resolutions,id'
        ]);

        // Default value for keeping derivation active
        $will_continue_active_derivation = 1;
        $derivation = Derivation::find($request->derivation_id);

        // Handle different action types with specific validations
        switch ($request->action) {
            case 'derivar': // Derive action
                $request->validate([
                    'office_id' => 'required|integer|exists:offices,id',
                    'user_id' => 'required|integer|exists:users,id',
                ]);
                $office = Office::find($request->office_id);
                $request->comment = "De {$derivation->office->name} a {$office->name}";
                $will_continue_active_derivation = 0; // Inactivate current derivation
                break;

            case 'comentar': // Comment action
                $request->validate([
                    'comment' => 'required|string|max:500',
                ]);
                $will_continue_active_derivation = 1; // Keep derivation active
                break;

            case 'concluir': // Conclude action
            case 'anular':   // Cancel action
            case 'archivar': // Archive action
                $will_continue_active_derivation = 0; // Inactivate current derivation
                break;

            default:
                $will_continue_active_derivation = 1; // Default: keep derivation active
                break;
        }

        // Create the action record associated with the derivation
        $action = $derivation->actions()->create([
            'action' => $request->action,
            'comment' => $request->comment,
        ]);

        // Handle file upload if a file is provided
        if ($request->file) {
            $extension = $request->file->extension();
            $folder = $extension === 'pdf' ? 'pdfs' : 'images'; // Organize files by type
            $procedure = $derivation->procedure;
            // Store the file in the appropriate directory
            $path = $request->file->store('helpdesk/procedure_files/' . now()->year . '/' . ($procedure->applicant instanceof User ? 'auth' : 'guest') . '/' . $procedure->applicant_id . '/action_files/' . $folder, 's3');

            // Create file record in database
            ActionFile::create([
                'name' => $request->file->getClientOriginalName(),
                'path' => $path,
                'action_id' => $action->id,
            ]);
        }

        // If action is 'derive', create a new derivation for the target user
        if ($request->action === 'derivar') {
            Derivation::create([
                'procedure_id' => $derivation->procedure->id,
                'user_id' => $request->user_id,
                'office_id' => $request->office_id,
                'is_active' => 1
            ]);
        }

        // Update the current derivation active state
        $derivation->update([
            'is_active' => $will_continue_active_derivation
        ]);

        // Update the procedure state based on the action type
        $action_state_array = config('db_maps.action_state');
        if (array_key_exists($request->action, $action_state_array)) {
            $state_name = $action_state_array[$request->action];
            $state_id = ProcedureState::where('name', $state_name)->first()->id;

            $derivation->procedure->update([
                'procedure_state_id' => $state_id
            ]);
        }

        // If exists resolution_id, create the relationship with the resolution
        if ($request->resolution_id) {
            $action->resolutions()->attach($request->resolution_id);
        }

        // Return success response with derivation status
        return response()->json([
            'message' => 'Hecho',
            'success' => true,
            'will_continue_active_derivation' => $will_continue_active_derivation,
        ]);
    }

    public function save_expedient_number(Request $request)
    {
        try {
            $request->validate([
                'procedure_id' => 'required|integer|exists:procedures,id',
                'expedient_number' => 'required|string|max:100',
            ]);

            // Verificar si ya existe otro procedimiento con el mismo número de expediente
            $existingProcedure = Procedure::where('expedient_number', $request->expedient_number)
                ->where('id', '!=', $request->procedure_id)
                ->first();

            if ($existingProcedure) {
                return response()->json([
                    'message' => 'Ya existe un procedimiento con este número de expediente',
                    'success' => false
                ]);
            }

            $procedure = Procedure::find($request->procedure_id);
            $procedure->update([
                'expedient_number' => $request->expedient_number
            ]);

            return response()->json([
                'message' => 'Hecho',
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al procesar la solicitud',
                'success' => false
            ], 500);
        }
    }
}
