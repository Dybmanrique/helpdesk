<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DocumentTypeController extends Controller
{
    public function index(){
        return view('admin.document-types.index');
    }

    public function data()
    {
        $users = DocumentType::query()->orderBy('name', 'asc');

        return DataTables::of($users)
            ->addColumn('actions', function($row) {
                return ''; // Las acciones se renderizan en el frontend
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
