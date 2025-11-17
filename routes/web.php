<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SharedFileController;
use App\Http\Controllers\Admin\PrincipalController;
use App\Http\Controllers\Principal\BrandController;
use App\Http\Controllers\Principal\ProductController;
use App\Http\Controllers\Principal\DashboardController;
use App\Http\Controllers\Principal\Auth\LoginController;

use App\Http\Controllers\Principal\Auth\RegisterController;
use App\Http\Controllers\Principal\PrincipalLinkController;
use App\Http\Controllers\Principal\PrincipalProfileController;
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
      Route::resource('brands', BrandController::class)->except(['show']);
});

// Principal Routes
Route::prefix('principal')->name('principal.')->group(function () {
    Route::middleware(['auth:principal'])->group(function () {
            // Products routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/principal/products/{product}/details', [ProductController::class, 'showDetails'])->name('products.details');

        Route::resource('products', ProductController::class)->except(['show']);
    });
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    // ... existing routes
    
    // Product Routes
    Route::get('/products/pending', [ProductController::class, 'pending'])->name('products.pending');
    Route::post('/products/{id}/approve', [ProductController::class, 'approve'])->name('products.approve');
    Route::post('/products/{id}/reject', [ProductController::class, 'reject'])->name('products.reject');
    Route::resource('products', ProductController::class);
    
});

Route::middleware(['auth:principal'])->group(function () {
    Route::get('/profile/edit', [PrincipalProfileController::class, 'edit'])->name('principal.profile.edit');
    Route::post('/profile/update', [PrincipalProfileController::class, 'update'])->name('principal.profile.update');

});

Route::prefix('principal')->middleware('auth:principal')->group(function() {
    Route::get('/links/create', [PrincipalLinkController::class, 'create'])->name('principal.links.create');
    Route::post('/links', [PrincipalLinkController::class, 'store'])->name('principal.links.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    Route::prefix('principals/{principal}')->group(function () {
        // Addresses
        Route::post('/addresses', [PrincipalProfileController::class, 'store'])->name('principals.addresses.store');
        Route::patch('/addresses/{address}', [PrincipalProfileController::class, 'update'])->name('principals.addresses.update');
        Route::delete('/addresses/{address}', [PrincipalProfileController::class, 'destroy'])->name('principals.addresses.destroy');
    });
});


   // Principal Links CRUD
    Route::get('/links', [\App\Http\Controllers\Principal\PrincipalLinkController::class, 'index'])
        ->name('principal.links.index');

    Route::get('/links/create', [\App\Http\Controllers\Principal\PrincipalLinkController::class, 'create'])
        ->name('principal.links.create');

    Route::post('/links/store', [\App\Http\Controllers\Principal\PrincipalLinkController::class, 'store'])
        ->name('principal.links.store');

    Route::get('/links/{id}/edit', [\App\Http\Controllers\Principal\PrincipalLinkController::class, 'edit'])
        ->name('principal.links.edit');

    Route::put('/links/{id}', [\App\Http\Controllers\Principal\PrincipalLinkController::class, 'update'])
        ->name('principal.links.update');

    Route::get('/links/{id}', [\App\Http\Controllers\Principal\PrincipalLinkController::class, 'show'])
        ->name('principal.links.show');

    Route::delete('/links/{id}', [\App\Http\Controllers\Principal\PrincipalLinkController::class, 'destroy'])
        ->name('principal.links.destroy');



//         // Share routes
// Route::post('/principal/links/generate-share', [PrincipalLinkController::class, 'generateShare'])
//     ->name('principal.links.generate-share');
    
// Route::get('/principal/links/shared', [PrincipalLinkController::class, 'sharedLinks'])
//     ->name('principal.links.shared');
    
// Route::delete('/principal/links/revoke-share/{tokenId}', [PrincipalLinkController::class, 'revokeShare'])
//     ->name('principal.links.revoke-share');

// // Public shared link routes
// Route::get('/shared/link/{token}', [PrincipalLinkController::class, 'viewSharedLink'])
//     ->name('shared.link.view');
    
// Route::get('/shared/file/{token}/{file}', [SharedFileController::class, 'download'])
//     ->name('shared.file.download');
        
// Share routes
Route::post('/principal/links/generate-share', [PrincipalLinkController::class, 'generateShare'])
    ->name('principal.links.generate-share');
    
Route::get('/principal/links/shared', [PrincipalLinkController::class, 'sharedLinks'])
    ->name('principal.links.shared');
    
Route::delete('/principal/links/revoke-share/{tokenId}', [PrincipalLinkController::class, 'revokeShare'])
    ->name('principal.links.revoke-share');

// Public shared link routes
Route::get('/shared/link/{token}', [PrincipalLinkController::class, 'viewSharedLink'])
    ->name('shared.link.view');
    
Route::post('/principal/links/send-share-email', [PrincipalLinkController::class, 'sendShareEmail'])
    ->name('principal.links.send-share-email');
    
require __DIR__ . '/frontend.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/client.php';