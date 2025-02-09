<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcedureState;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProcedureStateController extends Controller
{
    public function index(){
        return view('admin.procedure-states.index');
    }

    public function data()
    {
        $users = ProcedureState::query()->orderBy('name', 'asc');

        return DataTables::of($users)
            ->addColumn('actions', function($row) {
                return ''; // Las acciones se renderizan en el frontend
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
