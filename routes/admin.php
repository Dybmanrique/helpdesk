<?php

use App\Http\Controllers\Admin\AdministrativeUsersController;
use App\Http\Controllers\Admin\AllProceduresController;
use App\Http\Controllers\Admin\DocumentTypeController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\ProcedureCategoryController;
use App\Http\Controllers\Admin\ProcedurePriorityController;
use App\Http\Controllers\Admin\ProceduresOfficeController;
use App\Http\Controllers\Admin\ProcedureStateController;
use App\Http\Controllers\Admin\PublicUsersController;
use App\Http\Controllers\Admin\ResolutionsController;
use App\Http\Controllers\Admin\ResolutionStatesController;
use App\Http\Controllers\Admin\ResolutionTypesController;
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

Route::get('/tramites-mi-oficina', [ProceduresOfficeController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.procedures_office.index');
Route::get('/tramites-mi-oficina/data', [ProceduresOfficeController::class, 'data'])->middleware(['auth', 'verified'])->name('admin.procedures_office.data');
Route::post('/tramites-mi-oficina/info-tramite', [ProceduresOfficeController::class, 'info_procedure'])->middleware(['auth', 'verified'])->name('admin.procedures_office.info_procedure');
Route::get('/tramites-mi-oficina/generar-numero-expediente', [ProceduresOfficeController::class, 'generate_expedient_number'])->middleware(['auth', 'verified'])->name('admin.procedures_office.generate_expedient_number');
Route::post('/tramites-mi-oficina/usuarios-oficina', [ProceduresOfficeController::class, 'users_office'])->middleware(['auth', 'verified'])->name('admin.procedures_office.users_office');
Route::post('/tramites-mi-oficina/guardar-accion', [ProceduresOfficeController::class, 'save_action'])->middleware(['auth', 'verified'])->name('admin.procedures_office.save_action');
Route::post('/tramites-mi-oficina/guardar-numero-expediente', [ProceduresOfficeController::class, 'save_expedient_number'])->middleware(['auth', 'verified'])->name('admin.procedures_office.save_expedient_number');

Route::get('/tipos-de-resolucion', [ResolutionTypesController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.resolution_types.index');
Route::get('/tipos-de-resolucion/data', [ResolutionTypesController::class, 'data'])->middleware(['auth', 'verified'])->name('admin.resolution_types.data');
Route::post('/tipos-de-resolucion/guardar-tipo-resolucion', [ResolutionTypesController::class, 'store'])->middleware(['auth', 'verified'])->name('admin.resolution_types.store');
Route::post('/tipos-de-resolucion/actualizar-tipo-resolucion', [ResolutionTypesController::class, 'update'])->middleware(['auth', 'verified'])->name('admin.resolution_types.update');
Route::delete('/tipos-de-resolucion/eliminar-tipo-resolucion/{id}', [ResolutionTypesController::class, 'destroy'])->middleware(['auth', 'verified'])->name('admin.resolution_types.destroy');

Route::get('/estados-de-resolucion', [ResolutionStatesController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.resolution_states.index');
Route::get('/estados-de-resolucion/data', [ResolutionStatesController::class, 'data'])->middleware(['auth', 'verified'])->name('admin.resolution_states.data');
Route::post('/estados-de-resolucion/guardar-estado-resolucion', [ResolutionStatesController::class, 'store'])->middleware(['auth', 'verified'])->name('admin.resolution_states.store');
Route::post('/estados-de-resolucion/actualizar-estado-resolucion', [ResolutionStatesController::class, 'update'])->middleware(['auth', 'verified'])->name('admin.resolution_states.update');
Route::delete('/estados-de-resolucion/eliminar-estado-resolucion/{id}', [ResolutionStatesController::class, 'destroy'])->middleware(['auth', 'verified'])->name('admin.resolution_states.destroy');

Route::get('/resoluciones', [ResolutionsController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.resolutions.index');
Route::get('/resoluciones/data', [ResolutionsController::class, 'data'])->middleware(['auth', 'verified'])->name('admin.resolutions.data');
Route::post('/resoluciones/guardar-resolucion', [ResolutionsController::class, 'store'])->middleware(['auth', 'verified'])->name('admin.resolutions.store');
Route::post('/resoluciones/actualizar-resolucion', [ResolutionsController::class, 'update'])->middleware(['auth', 'verified'])->name('admin.resolutions.update');
Route::get('/resoluciones/ver-archivo/{uuid}', [ResolutionsController::class, 'view_file'])->middleware(['auth', 'verified'])->name('admin.resolutions.view_file');
Route::delete('/resoluciones/eliminar-resolucion/{id}', [ResolutionsController::class, 'destroy'])->middleware(['auth', 'verified'])->name('admin.resolutions.destroy');

Route::get('/usuarios-administrativos', [AdministrativeUsersController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.administrative_users.index');
Route::get('/usuarios-administrativos/data', [AdministrativeUsersController::class, 'data'])->middleware(['auth', 'verified'])->name('admin.administrative_users.data');
Route::post('/usuarios-administrativos/guardar-usuario', [AdministrativeUsersController::class, 'store'])->middleware(['auth', 'verified'])->name('admin.administrative_users.store');
Route::post('/usuarios-administrativos/actualizar-usuario', [AdministrativeUsersController::class, 'update'])->middleware(['auth', 'verified'])->name('admin.administrative_users.update');
Route::delete('/usuarios-administrativos/eliminar-usuario/{id}', [AdministrativeUsersController::class, 'destroy'])->middleware(['auth', 'verified'])->name('admin.administrative_users.destroy');

Route::get('/usuarios-publicos', [PublicUsersController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.public_users.index');
Route::get('/usuarios-publicos/data', [PublicUsersController::class, 'data'])->middleware(['auth', 'verified'])->name('admin.public_users.data');
Route::post('/usuarios-publicos/guardar-usuario', [PublicUsersController::class, 'store'])->middleware(['auth', 'verified'])->name('admin.public_users.store');
Route::post('/usuarios-publicos/actualizar-usuario', [PublicUsersController::class, 'update'])->middleware(['auth', 'verified'])->name('admin.public_users.update');
Route::delete('/usuarios-publicos/eliminar-usuario/{id}', [PublicUsersController::class, 'destroy'])->middleware(['auth', 'verified'])->name('admin.public_users.destroy');