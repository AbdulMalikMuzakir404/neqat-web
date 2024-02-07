<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->name('index');
Route::post('/store', [UserController::class, 'store'])->name('store');
Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
Route::post('/update/active', [UserController::class, 'updateActive'])->name('update.active');
Route::post('/delete', [UserController::class, 'destroy'])->name('delete');
