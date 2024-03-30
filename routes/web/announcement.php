<?php

use App\Http\Controllers\Announcement\AnnouncementController;
use App\Http\Controllers\Announcement\TemporaryFileController;
use Illuminate\Support\Facades\Route;

// crud data utama
Route::get('/', [AnnouncementController::class, 'index'])->name('index');
Route::get('/get/{id}/data', [AnnouncementController::class, 'getOneData'])->name('getonedata');
Route::post('/get-data', [AnnouncementController::class, 'getAllData'])->name('getalldata');
Route::post('/store', [AnnouncementController::class, 'store'])->name('store');
Route::post('/update', [AnnouncementController::class, 'update'])->name('update');
Route::post('/delete', [AnnouncementController::class, 'destroy'])->name('delete');

// crud data utama tambahan
Route::controller(TemporaryFileController::class)->group(function(){
    Route::match(['post','delete'],'temp/upload', 'index')->name('temporary.upload');
});

// crud data trash
Route::get('/trash', [AnnouncementController::class, 'trash'])->name('trash');
Route::get('/count-data-trash', [AnnouncementController::class, 'countDataTrash'])->name('countdata.trash');
Route::post('/get-data-trash', [AnnouncementController::class, 'getAllDataTrash'])->name('getalldata.trash');
Route::post('/delete-permanen', [AnnouncementController::class, 'destroyPermanen'])->name('delete.permanen');
Route::post('/recovery', [AnnouncementController::class, 'recovery'])->name('recovery');

// crud data temporary file
Route::get('/count-data-temp', [AnnouncementController::class, 'countDataTemp'])->name('countdata.temp');
