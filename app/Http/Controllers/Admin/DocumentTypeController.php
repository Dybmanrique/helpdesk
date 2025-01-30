<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class DocumentTypeController extends Controller
{
    public function index(){
        return view('admin.document-types.index');
    }
    
    public function data(){
        return DocumentType::all();
    }
}
