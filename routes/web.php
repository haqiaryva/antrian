<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;

Route::get('/', function () {
    return view('welcome');
});

// Ini untuk Rute ke Halaman Dashboard, Queue, dan Client
Route::get('/dashboard', [ViewController::class, 'dashboard'])->name('dashboard');
Route::get('/queue', [ViewController::class, 'queue'])->name('queue');
Route::get('/client', [ViewController::class, 'client'])->name('client');