<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PrincipalController;
use App\Http\Controllers\Principal\Auth\LoginController;
use App\Http\Controllers\Principal\Auth\RegisterController;
use App\Http\Controllers\Principal\Auth\PrincipalAuthController;
use App\Http\Controllers\Principal\PrincipalDashboardController;
use App\Http\Controllers\Principal\Auth\EmailVerificationController;

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

// Public verification route - accessible without authentication
// Route::get('/principal/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])
//     ->middleware('signed')
//     ->name('principal.verification.verify');

// // Guest routes (including verification notice)
// Route::prefix('principal')->name('principal.')->middleware('guest:principal')->group(function () {
//     Route::get('login', [LoginController::class, 'show'])->name('login');
//     Route::post('login', [LoginController::class, 'login'])->name('login.submit');

//     Route::get('register', [RegisterController::class, 'show'])->name('register');
//     Route::post('register', [RegisterController::class, 'register'])->name('register.submit');

//     // Verification notice should be accessible to guests
//     Route::get('verify-email', [EmailVerificationController::class, 'notice'])
//         ->name('verification.notice');
        
//     Route::post('email/verification-notification', [EmailVerificationController::class, 'send'])
//         ->middleware('throttle:6,1')
//         ->name('verification.send');
// });

// // Authenticated principal routes
// Route::prefix('principal')->name('principal.')->middleware(['auth:principal'])->group(function () {
//     // Protected routes that require verification
//     Route::middleware(['verified.principal'])->group(function () {
//         Route::get('dashboard', [PrincipalDashboardController::class, 'index'])->name('dashboard');
//     });

//     Route::post('logout', [LoginController::class, 'logout'])->name('logout');
// });

// Public verification route
Route::get('/principal/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware('signed')
    ->name('principal.verification.verify');

// Guest routes
Route::prefix('principal')->name('principal.')->middleware('guest:principal')->group(function () {
    Route::get('login', [LoginController::class, 'show'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');

    Route::get('register', [RegisterController::class, 'show'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register.submit');

    Route::get('verify-email', [EmailVerificationController::class, 'notice'])
        ->name('verification.notice');
        
    Route::post('email/verification-notification', [EmailVerificationController::class, 'send'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

// Authenticated principal routes with status check
Route::prefix('principal')->name('principal.')->middleware(['auth:principal', 'check.principal.status'])->group(function () {
    
    // Email verification routes (allow access even if not verified, but check status)
    Route::get('verify-email', [EmailVerificationController::class, 'notice'])
        ->name('verification.notice')
        ->withoutMiddleware(['verified.principal']);
        
    Route::post('email/verification-notification', [EmailVerificationController::class, 'send'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Protected routes that require both authentication and email verification
    Route::middleware(['verified.principal'])->group(function () {
        Route::get('dashboard', [PrincipalDashboardController::class, 'index'])->name('dashboard');
        // Add other protected routes here
    });

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::prefix('principal')->name('principal.')->middleware(['auth:principal', 'verified'])->group(function () {
    Route::get('principals', [PrincipalController::class, 'index'])->name('principals.index');
    Route::get('principals/{principal}', [PrincipalController::class, 'show'])->name('principals.show');
    Route::patch('principals/{principal}/status', [PrincipalController::class, 'updateStatus'])->name('principals.update-status');
    Route::get('principals-stats', [PrincipalController::class, 'getStats'])->name('principals.stats');
});

