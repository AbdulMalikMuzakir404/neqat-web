<?php

use App\Http\Controllers\UserAllTrash\UserAllTrashController;
use Illuminate\Support\Facades\Route;

// crud data utama
Route::get('/', [UserAllTrashController::class, 'index'])->name('index');
Route::get('/get/{id}/data', [UserAllTrashController::class, 'getOneData'])->name('getonedata');
Route::post('/get-data', [UserAllTrashController::class, 'getAllData'])->name('getalldata');
Route::post('/delete', [UserAllTrashController::class, 'destroy'])->name('delete');
