<?php

use App\Http\Controllers\HelpDesk\HelpdeskDashboardController;
use App\Http\Controllers\HelpDesk\ProcedureController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('helpdesk.dashboard');
// })->middleware(['auth', 'verified'])->name('helpdesk.dashboard');

Route::get('/', [HelpdeskDashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('helpdesk.dashboard');
Route::get('tramites/registro', [ProcedureController::class, 'create'])->name('procedures.create');
Route::get('tramites/consulta', [ProcedureController::class, 'consult'])->name('procedures.consult');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::view('/','helpdesk.dashboard')->name('helpdesk.dashboard');
});
