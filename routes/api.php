<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardApiController;
use App\Http\Controllers\DataKaryawanApiController;
use App\Http\Controllers\DataAbsensiApiController;


Route::get('dashboard', [DashboardApiController::class, 'list']);

Route::get('data-karyawan', [DataKaryawanApiController::class, 'list']);
Route::get('data-karyawan/{id}', [DataKaryawanApiController::class, 'detail']);
Route::post('data-karyawan', [DataKaryawanApiController::class, 'store']);
Route::put('data-karyawan/{id}/update', [DataKaryawanApiController::class, 'update']);
Route::delete('data-karyawan/{id}/delete', [DataKaryawanApiController::class, 'delete']);

Route::post('data-absensi', [DataAbsensiApiController::class, 'list']);
Route::post('data-absensi/add', [DataAbsensiApiController::class, 'store']);
