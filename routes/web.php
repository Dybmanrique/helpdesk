<?php

use App\Http\Controllers\FileViewController;
use App\Http\Controllers\GoogleOAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->middleware('can:Perfil de Usuario: Ver')->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->middleware('can:Perfil de Usuario: Actualizar Información')->name('profile.update');
    Route::patch('/perfil', [ProfileController::class, 'deactivate'])->middleware('can:Perfil de Usuario: Desactivar Cuenta')->name('profile.deactivate');
});

Route::get('/tramites/ver-archivo/{uuid}', [FileViewController::class, 'viewProcedureFile'])->name('file_view.view_procedure_file');
Route::get('/acciones/ver-archivo/{uuid}', [FileViewController::class, 'viewActionFile'])->name('file_view.view_action_file');
Route::get('/resoluciones/ver-archivo/{uuid}', [FileViewController::class, 'viewResolutionFile'])->name('file_view.view_resolution_file');

Route::middleware('guest')->group(function () {
    Route::get('/auth/google', [GoogleOAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleOAuthController::class, 'handleGoogleCallback'])->name('auth.google_callback');
    Route::get('/completar-registro', [GoogleOAuthController::class, 'create'])->name('complete_registration_form');
    Route::post('/completar-registro', [GoogleOAuthController::class, 'store'])->name('store_complete_registration');
});

require __DIR__ . '/auth.php';
