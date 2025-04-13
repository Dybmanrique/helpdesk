<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProcedureResource;
use App\Models\ActionFile;
use App\Models\Derivation;
use App\Models\Office;
use App\Models\Procedure;
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
        ->orderBy('d.id','desc')
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

    public function info_procedure(Request $request){
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

    public function generate_expedient_number(){
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

    public function users_office(Request $request){
        $office = Office::findOrFail($request->office_id);
        $users = $office->users()->with('person')->select('users.id','person_id')->get();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function save_action(Request $request){
        // $request->validate([
        //     'derivation_id' => 'required|integer|exists:derivations,id',
        //     'action' => 'required|string',
        //     'office_id' => 'nullable|integer|exists:offices,id',
        //     'user_id' => 'nullable|integer|exists:users,id',
        //     'comment' => 'nullable|string',
        //     'file' => 'nullable|file|max:5120',
        // ]);

        $request->validate([
            'derivation_id' => 'required|integer|exists:derivations,id',
            'comment' => 'nullable|string|max:500',
            'file' => 'nullable|file|max:5120|mimes:pdf,jpg,png'
        ]);

        $will_continue_active_derivation = 1;
        $derivation = Derivation::find($request->derivation_id);

        switch ($request->action) {
            case 'derivar':
                $request->validate([
                    'office_id' => 'required|integer|exists:offices,id',
                    'user_id' => 'required|integer|exists:users,id',
                    'comment' => 'nullable|string|max:500',
                    'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,png'
                ]);
                $will_continue_active_derivation = 0;
                break;

            case 'comentar':
                $request->validate([
                    'comment' => 'required|string|max:500',
                    'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,png'
                ]);
                $will_continue_active_derivation = 1;
                break;

            case 'concluir': 
            case 'anular': 
            case 'archivar':
                $request->validate([
                    'comment' => 'nullable|string|max:500',
                    'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,png'
                ]);
                $will_continue_active_derivation = 0;
                break;
            
            default:
                $will_continue_active_derivation = 1;
                break;
        }

        $action = $derivation->actions()->create([
            'action' => $request->action,
            'comment' => $request->comment,
        ]);

        if($request->file){
            $extension = $request->file->extension();
            $folder = $extension === 'pdf' ? 'pdfs' : 'images';

            $path = $request->file->store('helpdesk/procedure_files/auth/' . $derivation->user->id . '/' . $folder);

            ActionFile::create([
                'name' => $request->file->getClientOriginalName(),
                'path' => $path,
                'action_id' => $action->id
            ]);
        }

        if($request->action === 'derivar'){
            Derivation::create([
                'procedure_id' => $derivation->procedure->id,
                'user_id' => $request->user_id,
                'is_active' => 1
            ]);
        }

        $derivation->update([
            'is_active' => $will_continue_active_derivation
        ]);

        // if($will_continue_active_derivation === 0){
        //     // $this->dispatch('closeModal');
        //     // $this->dispatch('refreshTable');
        // }

        return response()->json([
            'message' => 'Hecho',
            'success' => true,
            'will_continue_active_derivation' => $will_continue_active_derivation,
        ]);
    }
}
