<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Procedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProceduresOfficeController extends Controller
{
    public function index()
    {
        return view('admin.procedures-office.index');
    }

    public function data()
    {
        $user = Auth::user();
        $procedures = $user->active_procedures()
            ->with([
                'document_type:id,name',
                'procedure_category:id,name',
                'procedure_priority:id,name',
                'procedure_state:id,name',
                'user:id,person_id,email',
                'user.person:id,name,last_name,second_last_name,phone'
            ])
            ->select('procedures.id', 'ticket', 'reason', 'description', 'document_type_id', 'procedure_category_id', 'procedure_priority_id', 'procedure_state_id', 'procedures.user_id')
            ->get();

        return DataTables::of($procedures)
            ->addColumn('actions', function ($row) {
                return ''; // Las acciones se renderizan en el frontend
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
