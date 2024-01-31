<?php

use App\Http\Controllers\Announcement\AnnouncementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AnnouncementController::class, 'index'])->name('index');
