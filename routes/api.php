<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MataKuliahController;
use App\Http\Controllers\Api\CplController;
use App\Http\Controllers\Api\CpmkController;
use App\Http\Controllers\Api\MappingController;
use App\Http\Controllers\Api\RpsController;
use App\Http\Controllers\Api\PertemuanController;

Route::post('/login', [AuthController::class, 'login']);

// Group Route CRUD
Route::get('/mata-kuliah', [MataKuliahController::class, 'index']);
Route::post('/mata-kuliah', [MataKuliahController::class, 'store']);
Route::delete('/mata-kuliah/{id}', [MataKuliahController::class, 'destroy']); // <-- Tambah ini

Route::get('/cpl', [CplController::class, 'index']);
Route::post('/cpl', [CplController::class, 'store']);
Route::delete('/cpl/{id}', [CplController::class, 'destroy']); // <-- Tambah ini

Route::get('/cpmk', [CpmkController::class, 'index']);
Route::post('/cpmk', [CpmkController::class, 'store']);
Route::delete('/cpmk/{id}', [CpmkController::class, 'destroy']); // <-- Tambah ini

Route::get('/mapping', [MappingController::class, 'index']);
Route::post('/mapping', [MappingController::class, 'store']);
Route::delete('/mapping/{id}', [MappingController::class, 'destroy']); // <-- Tambah ini

Route::get('/rps', [RpsController::class, 'index']);
Route::post('/rps', [RpsController::class, 'store']);
Route::put('/rps/{id}/validasi', [RpsController::class, 'validasi']);
Route::get('/riwayat-revisi', [RpsController::class, 'riwayatRevisi']);

Route::get('/pertemuan/{rps_id}', [PertemuanController::class, 'getByRps']);
Route::post('/pertemuan', [PertemuanController::class, 'store']);