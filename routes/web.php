<?php

use App\Http\Controllers\FileViewController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->middleware('can:Perfil de Usuario: Ver')->name('profile.edit');
    Route::put('/perfil', [ProfileController::class, 'update'])->middleware('can:Perfil de Usuario: Actualizar Información')->name('profile.update');
    Route::patch('/perfil', [ProfileController::class, 'deactivate'])->middleware('Perfil de Usuario: Desactivar Cuenta')->name('profile.deactivate');
});

Route::get('/ver-archivo/{file}', [FileViewController::class, 'view'])->name('file_view.view');

require __DIR__ . '/auth.php';
