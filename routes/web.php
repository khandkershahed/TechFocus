<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Principal\Auth\PrincipalAuthController;
use App\Http\Controllers\Principal\Auth\EmailVerificationController;
use App\Http\Controllers\Principal\PrincipalDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


require __DIR__ . '/frontend.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/client.php';


// Route::get('/', [\App\Http\Controllers\SiteController::class, 'index'])
//     ->name('index');
// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');

//     Route::get('profile', [\App\Http\Controllers\SiteController::class, 'profile'])
//         ->middleware('password.confirm')
//         ->name('profile');
// });



// Guest routes
Route::prefix('principal')->name('principal.')->middleware('guest:principal')->group(function () {
    Route::get('login', [PrincipalAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [PrincipalAuthController::class, 'login'])->name('login.submit');

    Route::get('register', [PrincipalAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [PrincipalAuthController::class, 'register'])->name('register.submit');
});

// Public email verification
Route::get('principal/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->name('principal.verification.verify')
    ->middleware('signed');

// Authenticated routes
Route::prefix('principal')->name('principal.')->middleware('auth:principal')->group(function () {
    Route::get('dashboard', [PrincipalDashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [PrincipalAuthController::class, 'logout'])->name('logout');

    Route::get('verify-email', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::post('email/verification-notification', [EmailVerificationController::class, 'send'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});
