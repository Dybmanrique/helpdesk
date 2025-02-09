<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OfficeController extends Controller
{
    public function index(){
        return view('admin.offices.index');
    }

    public function data()
    {
        $users = Office::query()->orderBy('name', 'asc');

        return DataTables::of($users)
            ->addColumn('actions', function($row) {
                return ''; // Las acciones se renderizan en el frontend
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
