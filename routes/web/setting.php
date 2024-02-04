<?php

use App\Http\Controllers\Setting\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SettingController::class, 'index'])->name('index');
Route::put('/update-setting/general', [SettingController::class, 'updateGeneral'])->name('update.general');
Route::put('/update-setting/map', [SettingController::class, 'updateMap'])->name('update.map');
