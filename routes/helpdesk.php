<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('prueba1');
})->middleware(['auth'])->name('helpdesk.dashboard');