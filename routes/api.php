<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QueueController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\StaffController;

// Untuk dapat Authorization Bearer Token di Header
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rute untuk Meneruskan Data dari Database ke Tampilan Halaman Dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);

// Rute untuk dapat antrian selanjutnya
Route::get('/queue/next', [QueueController::class, 'getNextQueue']);
// Rute untuk meneruskan nomer antrian ke staff
Route::post('/queue', [QueueController::class, 'store']);

// Rute untuk mendapatkan status staff berdasarkan ID
Route::get('/staff/{id}/status', [StaffController::class, 'status']);

// Rute untuk menghidupkan dan Mematikan Status Staff
Route::post('/staff/{id}/activate', [StaffController::class, 'activate']);
Route::post('/staff/{id}/deactivate', [StaffController::class, 'deactivate']);

// Rute Mengambil Nomer Antrian Berdasarkan Algoritma 2x reservasi 1x Walk-in, serta Menyelesaikan Antrian
Route::post('/queue/request', [QueueController::class, 'requestQueue']);
Route::post('/queue/finish', [QueueController::class, 'finishQueue']);