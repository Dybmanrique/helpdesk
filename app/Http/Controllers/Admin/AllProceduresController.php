<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Procedure;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AllProceduresController extends Controller
{
    public function index(){
        return view('admin.all-procedures.index');
    }

    public function data()
    {
        $all_procedures = Procedure::query()
            ->with([
                'document_type:id,name',  
                'procedure_category:id,name',  
                'procedure_priority:id,name',  
                'procedure_state:id,name',  
                'user:id,person_id,email',  
                'user.person:id,name,last_name,second_last_name,phone'
            ])
            ->select('id','ticket','reason','description', 'document_type_id', 'procedure_category_id', 'procedure_priority_id', 'procedure_state_id', 'user_id')
            ->get();


        return DataTables::of($all_procedures)
            ->addColumn('actions', function($row) {
                return ''; // Las acciones se renderizan en el frontend
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
