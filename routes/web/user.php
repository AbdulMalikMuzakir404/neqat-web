<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index'])->name('index');
Route::post('/get-data', [UserController::class, 'getAllData'])->name('getalldata');
Route::post('/store', [UserController::class, 'store'])->name('store');
Route::post('/update', [UserController::class, 'update'])->name('update');
Route::post('/delete', [UserController::class, 'destroy'])->name('delete');

Route::get('/get/{id}/data', [UserController::class, 'getOneData'])->name('getonedata');
Route::post('/update/active', [UserController::class, 'updateActive'])->name('update.active');
Route::get('/get-role', [UserController::class, 'getAllRole'])->name('getallrole');

Route::get('/trash', [UserController::class, 'trash'])->name('trash');
Route::get('/data-trash', [UserController::class, 'getDataTrash'])->name('data.trash');
Route::post('/get-data-trash', [UserController::class, 'getAllDataTrash'])->name('getalldata.trash');
Route::post('/delete-permanen', [UserController::class, 'destroyPermanen'])->name('delete.permanen');
Route::post('/recovery', [UserController::class, 'recovery'])->name('recovery');

Route::post('/export', [UserController::class, 'export'])->name('export');
