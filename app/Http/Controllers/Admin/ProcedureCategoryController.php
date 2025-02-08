<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcedureCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProcedureCategoryController extends Controller
{
    public function index(){
        return view('admin.procedure-categories.index');
    }

    public function data()
    {
        $users = ProcedureCategory::query()->orderBy('name', 'asc');

        return DataTables::of($users)
            ->addColumn('actions', function($row) {
                return '';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
