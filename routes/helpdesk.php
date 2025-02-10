<?php

use App\Http\Controllers\HelpDesk\ProcedureController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('helpdesk.dashboard');
})->middleware(['auth', 'verified'])->name('helpdesk.dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::view('/','helpdesk.dashboard')->name('helpdesk.dashboard');
    Route::get('tramites/search', [ProcedureController::class, 'search'])->name('tramites.search');
    Route::resource('tramites', ProcedureController::class);
});
