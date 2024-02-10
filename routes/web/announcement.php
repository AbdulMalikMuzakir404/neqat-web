<?php

use App\Http\Controllers\Announcement\AnnouncementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AnnouncementController::class, 'index'])->name('index');
Route::post('/get-data', [AnnouncementController::class, 'getData'])->name('getData');
Route::post('/store', [AnnouncementController::class, 'store'])->name('store');
Route::post('/update', [AnnouncementController::class, 'update'])->name('update');
Route::post('/delete', [AnnouncementController::class, 'destroy'])->name('delete');

