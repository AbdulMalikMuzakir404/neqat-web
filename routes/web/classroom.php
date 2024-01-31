<?php

use App\Http\Controllers\ClassRoom\ClassRoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClassRoomController::class, 'index'])->name('index');
