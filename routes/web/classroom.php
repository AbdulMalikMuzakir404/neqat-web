<?php

use App\Http\Controllers\ClassRoom\ClassRoomController;
use Illuminate\Support\Facades\Route;

// crud data utama
Route::get('/', [ClassRoomController::class, 'index'])->name('index');
Route::get('/get/{id}/data', [ClassRoomController::class, 'getOneData'])->name('getonedata');
Route::post('/get-data', [ClassRoomController::class, 'getAllData'])->name('getalldata');
Route::post('/store', [ClassRoomController::class, 'store'])->name('store');
Route::post('/update', [ClassRoomController::class, 'update'])->name('update');
Route::post('/delete', [ClassRoomController::class, 'destroy'])->name('delete');

// crud data trash
Route::get('/trash', [ClassRoomController::class, 'trash'])->name('trash');
Route::get('/count-data-trash', [ClassRoomController::class, 'countDataTrash'])->name('countdata.trash');
Route::post('/get-data-trash', [ClassRoomController::class, 'getAllDataTrash'])->name('getalldata.trash');
Route::post('/delete-permanen', [ClassRoomController::class, 'destroyPermanen'])->name('delete.permanen');
Route::post('/recovery', [ClassRoomController::class, 'recovery'])->name('recovery');
