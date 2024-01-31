<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'showLoginForm']);

Auth::routes(['verify' => true]);

// HOME ROUTE
Route::middleware(['auth'])->group(function () {
    Route::name('home.')->prefix('/home')->group(function () {
        include __DIR__ . '/web/home.php';
    });
});

// USER ROUTE
Route::middleware(['auth'])->group(function () {
    Route::name('user.')->prefix('/user')->group(function () {
        include __DIR__ . '/web/user.php';
    });
});

// ANNOUNCEMENT ROUTE
Route::middleware(['auth'])->group(function () {
    Route::name('announcement.')->prefix('/announcement')->group(function () {
        include __DIR__ . '/web/announcement.php';
    });
});

// CLASS ROOM ROUTE
Route::middleware(['auth'])->group(function () {
    Route::name('classroom.')->prefix('/classroom')->group(function () {
        include __DIR__ . '/web/classroom.php';
    });
});

// SRUDENT ROUTE
Route::middleware(['auth'])->group(function () {
    Route::name('student.')->prefix('/student')->group(function () {
        include __DIR__ . '/web/student.php';
    });
});

// ATTENDANCE ROUTE
Route::middleware(['auth'])->group(function () {
    Route::name('attendance.')->prefix('/attendance')->group(function () {
        include __DIR__ . '/web/attendance.php';
    });
});

// CALENDAR ROUTE
Route::middleware(['auth'])->group(function () {
    Route::name('calendar.')->prefix('/calendar')->group(function () {
        include __DIR__ . '/web/calendar.php';
    });
});

// SETTING ROUTE
Route::middleware(['auth'])->group(function () {
    Route::name('setting.')->prefix('/setting')->group(function () {
        include __DIR__ . '/web/setting.php';
    });
});
