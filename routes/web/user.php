<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->name('index');
Route::post('/store', [UserController::class, 'store'])->name('store');
Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
Route::delete('/delete/{$id}', [UserController::class, 'destroy'])->name('delete');
