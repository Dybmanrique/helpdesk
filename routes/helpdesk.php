<?php

use App\Http\Controllers\HelpDesk\HelpdeskDashboardController;
use App\Http\Controllers\HelpDesk\ProcedureController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HelpdeskDashboardController::class, 'dashboard'])->middleware(['auth', 'verified', 'can:Dashboard de Trámites: Ver'])->name('helpdesk.dashboard');
Route::get('tramites/registro', [ProcedureController::class, 'create'])->name('procedures.create');
Route::get('tramites/consulta/{code?}', [ProcedureController::class, 'consult'])->name('procedures.consult');
