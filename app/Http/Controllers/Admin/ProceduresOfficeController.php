<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProcedureResource;
use App\Models\ActionFile;
use App\Models\Derivation;
use App\Models\Office;
use App\Models\Procedure;
use App\Models\ProcedureState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProceduresOfficeController extends Controller
{
    public function index()
    {
        $offices = Office::all();
        return view('admin.procedures-office.index', compact('offices'));
    }

    public function data()
    {
        $user = Auth::user();
        $procedures = DB::table('users as u')
            ->join('people as po', 'po.id', '=', 'u.person_id')
            ->join('derivations as d', 'd.user_id', '=', 'u.id')
            ->join('procedures as p', 'p.id', '=', 'd.procedure_id')
            ->join('procedure_states as ps', 'ps.id', '=', 'p.procedure_state_id')
            ->join('procedure_categories as pc', 'pc.id', '=', 'p.procedure_category_id')
            ->join('procedure_priorities as pp', 'pp.id', '=', 'p.procedure_priority_id')
            ->join('document_types as dt', 'dt.id', '=', 'p.document_type_id')
            ->where('d.is_active', true)
            ->where('u.id', $user->id)
            ->orderBy('d.id', 'desc')
            ->select([
                'd.id as derivation_id',
                'p.id as procedure_id',
                'u.email',
                'po.name',
                'po.last_name',
                'po.second_last_name',
                'po.phone',
                'po.address',
                'po.identity_number',
                'p.expedient_number',
                'p.reason',
                'p.description',
                'p.ticket',
                'ps.name as procedure_state',
                'pc.name as procedure_category',
                'pp.name as procedure_priority',
                'dt.name as document_type',
            ])
            ->get();

        return DataTables::of($procedures)
            ->addColumn('actions', function ($row) {
                return ''; // Las acciones se renderizan en el frontend
            })
            ->rawColumns(['actions'])
            ->make(true);
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
            'user.person',
            'files',
            'actions.action_files'
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

        $lastProcedure = Procedure::whereYear('created_at', $year)->orderByDesc('created_at')->first();

        $lastNumber = 0;

        if ($lastProcedure && preg_match('/EXP-(\d+)-' . $year . '/', $lastProcedure->expedient_number, $matches)) {
            $lastNumber = (int) $matches[1];
        }

        $nextNumber = $lastNumber + 1;

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
            'file' => 'nullable|file|max:5120|mimes:pdf,jpg,png'
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
                $will_continue_active_derivation = 0; // Inactivate current derivation
                break;

            case 'comentar': // Comment action
                $request->validate([
                    'comment' => 'required|string|max:500',
                    'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,png'
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

            // Store the file in the appropriate directory
            $path = $request->file->store('helpdesk/procedure_files/auth/' . $derivation->user->id . '/' . $folder);

            // Create file record in database
            ActionFile::create([
                'name' => $request->file->getClientOriginalName(),
                'path' => $path,
                'action_id' => $action->id
            ]);
        }

        // If action is 'derive', create a new derivation for the target user
        if ($request->action === 'derivar') {
            Derivation::create([
                'procedure_id' => $derivation->procedure->id,
                'user_id' => $request->user_id,
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
