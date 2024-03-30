<?php

use App\Http\Controllers\LogActivity\LogActivityController;
use Illuminate\Support\Facades\Route;

// crud data utama
Route::get('/', [LogActivityController::class, 'index'])->name('index');
Route::post('/get-data', [LogActivityController::class, 'getAllData'])->name('getalldata');
Route::post('/delete', [LogActivityController::class, 'destroy'])->name('delete');

// export
Route::post('/exportanddelete', [LogActivityController::class, 'exportAndDelete'])->name('exportanddelete');
