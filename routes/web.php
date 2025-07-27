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
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/ver-archivo/{file}', [FileViewController::class, 'view'])->name('file_view.view');

require __DIR__.'/auth.php';
