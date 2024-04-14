<?php

use App\Http\Controllers\Auth\CustomeVerificationController;
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

Route::get('/', [LoginController::class, 'showLoginForm'])->middleware('guest');

Auth::routes(['verify' => true]);

// HOME ROUTE
Route::middleware(['auth', 'verify_email'])->group(function () {
    Route::name('home.')->prefix('/home')->group(function () {
        include __DIR__ . '/web/home.php';
    });
});

// USER ROUTE
Route::middleware(['auth', 'verify_email'])->group(function () {
    Route::name('user.')->prefix('/user')->group(function () {
        include __DIR__ . '/web/user.php';
    });
});

// ANNOUNCEMENT ROUTE
Route::middleware(['auth', 'verify_email'])->group(function () {
    Route::name('announcement.')->prefix('/announcement')->group(function () {
        include __DIR__ . '/web/announcement.php';
    });
});

// TEMPORARY ROUTE
Route::middleware(['auth', 'verify_email'])->group(function () {
    Route::name('temporary.')->prefix('/temporary')->group(function () {
        include __DIR__ . '/web/temporary.php';
    });
});

// CLASS ROOM ROUTE
Route::middleware(['auth', 'verify_email'])->group(function () {
    Route::name('classroom.')->prefix('/classroom')->group(function () {
        include __DIR__ . '/web/classroom.php';
    });
});

// SRUDENT ROUTE
Route::middleware(['auth', 'verify_email'])->group(function () {
    Route::name('student.')->prefix('/student')->group(function () {
        include __DIR__ . '/web/student.php';
    });
});

// ATTENDANCE ROUTE
Route::middleware(['auth', 'verify_email'])->group(function () {
    Route::name('attendance.')->prefix('/attendance')->group(function () {
        include __DIR__ . '/web/attendance.php';
    });
});

// LOG ACTIVITY ROUTE
Route::middleware(['auth', 'verify_email', 'role:developer'])->group(function () {
    Route::name('logactivity.')->prefix('/logactivity')->group(function () {
        include __DIR__ . '/web/logactivity.php';
    });
});


// SETTING ROUTE
Route::middleware(['auth', 'verify_email'])->group(function () {
    Route::name('setting.')->prefix('/setting')->group(function () {
        include __DIR__ . '/web/setting.php';
    });
});

// VERIFICATION
Route::middleware(['auth'])->group(function () {
    Route::get('/verify-email', [CustomeVerificationController::class, 'showVerificationForm'])->name('custome.verification.notice');
    Route::post('/send-verification-email', [CustomeVerificationController::class, 'sendVerificationEmail'])->name('custome.verification.resend');
    Route::get('/verify-email/{token}', [CustomeVerificationController::class, 'verifyEmail'])->name('custome.verification.verify');
});
