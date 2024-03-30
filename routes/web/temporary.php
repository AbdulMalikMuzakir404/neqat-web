<?php

use App\Http\Controllers\Temporary\TemporaryController;
use App\Http\Controllers\Announcement\TemporaryFileController;
use Illuminate\Support\Facades\Route;

// crud data utama
Route::get('/', [TemporaryController::class, 'index'])->name('index');
Route::get('/get/{id}/data', [TemporaryController::class, 'getOneData'])->name('getonedata');
Route::post('/get-data', [TemporaryController::class, 'getAllData'])->name('getalldata');
Route::post('/delete', [TemporaryController::class, 'destroy'])->name('delete');
Route::controller(TemporaryFileController::class)->group(function(){
    Route::match(['post','delete'],'temp/upload', 'index')->name('temporary.upload');
});
