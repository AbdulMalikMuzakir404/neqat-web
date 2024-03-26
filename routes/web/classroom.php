<?php

use App\Http\Controllers\ClassRoom\ClassRoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClassRoomController::class, 'index'])->name('index');
Route::post('/get-data', [ClassRoomController::class, 'getAllData'])->name('getalldata');
Route::post('/store', [ClassRoomController::class, 'store'])->name('store');
Route::post('/update', [ClassRoomController::class, 'update'])->name('update');
Route::post('/delete', [ClassRoomController::class, 'destroy'])->name('delete');
