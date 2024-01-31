<?php

use App\Http\Controllers\Setting\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SettingController::class, 'index'])->name('index');
