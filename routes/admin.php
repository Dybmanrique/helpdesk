<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('prueba2');
})->middleware(['auth', 'verified'])->name('admin.dashboard');