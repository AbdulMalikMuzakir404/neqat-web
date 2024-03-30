<?php

use App\Http\Controllers\Student\StudentController;
use Illuminate\Support\Facades\Route;

// crud data utama
Route::get('/', [StudentController::class, 'index'])->name('index');
Route::get('/get/{id}/data', [StudentController::class, 'getOneData'])->name('getonedata');
Route::post('/get-data', [StudentController::class, 'getAllData'])->name('getalldata');
Route::post('/store', [StudentController::class, 'store'])->name('store');
Route::post('/update', [StudentController::class, 'update'])->name('update');
Route::post('/delete', [StudentController::class, 'destroy'])->name('delete');

// crud data utama tambahan
Route::post('/update/active', [StudentController::class, 'updateActive'])->name('update.active');
Route::get('/get-role', [StudentController::class, 'getAllRole'])->name('getallrole');

// crud data trash
Route::get('/trash', [StudentController::class, 'trash'])->name('trash');
Route::get('/count-data-trash', [StudentController::class, 'countDataTrash'])->name('countdata.trash');
Route::post('/get-data-trash', [StudentController::class, 'getAllDataTrash'])->name('getalldata.trash');
Route::post('/delete-permanen', [StudentController::class, 'destroyPermanen'])->name('delete.permanen');
Route::post('/recovery', [StudentController::class, 'recovery'])->name('recovery');

// import dan export
Route::post('/import', [StudentController::class, 'import'])->name('import');
Route::post('/export', [StudentController::class, 'export'])->name('export');
