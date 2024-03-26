<?php

use App\Http\Controllers\LogActivity\LogActivityController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LogActivityController::class, 'index'])->name('index');
Route::post('/get-data', [LogActivityController::class, 'getAllData'])->name('getalldata');
Route::post('/delete', [LogActivityController::class, 'destroy'])->name('delete');

Route::post('/exportanddelete', [LogActivityController::class, 'exportAndDelete'])->name('exportanddelete');
