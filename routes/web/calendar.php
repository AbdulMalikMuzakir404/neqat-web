<?php

use App\Http\Controllers\Calendar\CalendarController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CalendarController::class, 'index'])->name('index');
