<?php

use App\Http\Controllers\Admin\AllProceduresController;
use App\Http\Controllers\Admin\DocumentTypeController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\ProcedureCategoryController;
use App\Http\Controllers\Admin\ProcedurePriorityController;
use App\Http\Controllers\Admin\ProcedureStateController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::get('/tipos-de-documentos', [DocumentTypeController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.document_types.index');
Route::get('/tipos-de-documentos/data', [DocumentTypeController::class, 'data'])->middleware(['auth', 'verified'])->name('admin.document_types.data');

Route::get('/categorias-de-tramites', [ProcedureCategoryController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.procedure_categories.index');
Route::get('/categorias-de-tramites/data', [ProcedureCategoryController::class, 'data'])->middleware(['auth', 'verified'])->name('admin.procedure_categories.data');

Route::get('/prioridades-de-tramites', [ProcedurePriorityController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.procedure_priorities.index');
Route::get('/prioridades-de-tramites/data', [ProcedurePriorityController::class, 'data'])->middleware(['auth', 'verified'])->name('admin.procedure_priorities.data');

Route::get('/estados-de-tramites', [ProcedureStateController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.procedure_states.index');
Route::get('/estados-de-tramites/data', [ProcedureStateController::class, 'data'])->middleware(['auth', 'verified'])->name('admin.procedure_states.data');

Route::get('/oficinas', [OfficeController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.offices.index');
Route::get('/oficinas/data', [OfficeController::class, 'data'])->middleware(['auth', 'verified'])->name('admin.offices.data');

Route::get('/todos-los-tramites', [AllProceduresController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.all_procedures.index');
Route::get('/todos-los-tramites/data', [AllProceduresController::class, 'data'])->middleware(['auth', 'verified'])->name('admin.all_procedures.data');