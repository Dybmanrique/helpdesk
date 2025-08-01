<?php

use App\Http\Controllers\HelpDesk\HelpdeskDashboardController;
use App\Http\Controllers\HelpDesk\ProcedureController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HelpdeskDashboardController::class, 'dashboard'])->middleware(['auth', 'verified', 'can:Dashboard de Trámites: Ver'])->name('helpdesk.dashboard');
Route::get('tramites/registro', [ProcedureController::class, 'create'])->name('procedures.create');
Route::get('tramites/consulta/{code?}', [ProcedureController::class, 'consult'])->name('procedures.consult');
Route::get('tramites/ver-archivo/{uuid}', [ProcedureController::class, 'viewProcedureFile'])->name('procedures.view_file');
Route::get('tramites/acciones/ver-archivo/{uuid}', [ProcedureController::class, 'viewActionFile'])->name('procedures.view_action_file');
Route::get('tramites/resoluciones/ver-archivo/{uuid}', [ProcedureController::class, 'viewResolutionFile'])->name('procedures.view_resolution_file');
