<?php

use App\Http\Controllers\Admin\DocumentTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::get('/tipos-de-documentos', [DocumentTypeController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.document_types.index');
Route::get('/tipos-de-documentos/data', [DocumentTypeController::class, 'data'])->middleware(['auth', 'verified'])->name('admin.document_types.data');