<?php

use App\Http\Controllers\Announcement\AnnouncementController;
use App\Http\Controllers\Announcement\TemporaryFileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AnnouncementController::class, 'index'])->name('index');
Route::post('/get-data', [AnnouncementController::class, 'getAllData'])->name('getalldata');
Route::post('/store', [AnnouncementController::class, 'store'])->name('store');
Route::post('/update', [AnnouncementController::class, 'update'])->name('update');
Route::post('/delete', [AnnouncementController::class, 'destroy'])->name('delete');

Route::get('/get/{id}/data', [AnnouncementController::class, 'getOneData'])->name('getonedata');
Route::controller(TemporaryFileController::class)->group(function(){
    Route::match(['post','delete'],'temp/upload', 'index')->name('temporary.upload');
});

Route::get('/data-temp', [AnnouncementController::class, 'getDataTemp'])->name('data.temp');
