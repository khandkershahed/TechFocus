<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Rfq\RfqController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\SiteController;
Route::get('/', [SiteController::class, 'homePage'])->name('homepage');
Route::get('solution/{slug}', [SiteController::class, 'solutionDetails'])->name('solution.details');
Route::get('category/{slug}', [SiteController::class, 'category'])->name('category');
Route::get('catalog/all', [SiteController::class, 'allCatalog'])->name('catalog.all');
Route::get('faq', [SiteController::class, 'faq'])->name('faq');
Route::get('rfq', [SiteController::class, 'rfq'])->name('rfq');
Route::get('contact', [SiteController::class, 'contact'])->name('contact');
Route::post('contact-store', [ContactController::class, 'store'])->name('contact.add');
Route::get('terms', [SiteController::class, 'terms'])->name('terms');
Route::get('about-us', [SiteController::class, 'about'])->name('about');
Route::get('services', [SiteController::class, 'service'])->name('service');
Route::get('subscription', [SiteController::class, 'subscription'])->name('subscription');
Route::get('brand/list', [SiteController::class, 'brandList'])->name('brand.list');
Route::get('sourcing/guide', [SiteController::class, 'sourcingGuide'])->name('sourcing.guide');
Route::get('buying/guide', [SiteController::class, 'buyingGuide'])->name('buying.guide');
Route::get('exhibit', [SiteController::class, 'exhibit'])->name('exhibit');
Route::get('manufacturer/account', [SiteController::class, 'manufacturerAccount'])->name('manufacturer.account');
Route::get('category/{slug}/products', [SiteController::class, 'filterProducts'])->name('filtering.products');
// Search
Route::get('/search', [SiteController::class, 'ProductSearch'])->name('search.products'); // 
Route::post('/global-search', [SiteController::class, 'globalSearch'])->name('global.search');
Route::get('/product/{slug}', [SiteController::class, 'show'])->name('product.show');


// Brand Pages
Route::middleware('web')->group(function () {
    Route::get('/{slug}/overview', [PageController::class, 'overview'])->name('brand.overview');
    Route::get('/{id}/single-product/{slug}', [PageController::class, 'productDetails'])->name('product.details');
    Route::get('/{slug}/brochures', [PageController::class, 'brandPdf'])->name('brand.pdf');
    Route::get('/{slug}/products', [PageController::class, 'brandProducts'])->name('brand.products');
    Route::get('/catalogue-pdf/{slug}', [PageController::class, 'pdfDetails'])->name('pdf.details');
    Route::get('/{slug}/contents', [PageController::class, 'content'])->name('brand.content');
    Route::get('/contents/details/{slug}', [PageController::class, 'contentDetails'])->name('content.details');
    // Route::get('/{slug}/products', [PageController::class, 'ajaxBrandProductsPagination'])->name('brand.products.pagination');
});


//Route::get('/product/{slug}', [SiteController::class, 'show'])->name('product.show');


// Product search page
Route::get('/search', [SiteController::class, 'ProductSearch'])->name('search.products');
Route::get('/news/{slug}', [SiteController::class, 'newsDetails'])->name('news.details');

Route::get('/product-details/{slug}', [SiteController::class, 'productDetails'])->name('product.product_details');

Route::post('/rfq/submit', [RfqController::class, 'store'])->name('rfq.submit');

// Cart routes
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/debug', [CartController::class, 'debugCart'])->name('cart.debug');
Route::get('/cart/view', [CartController::class, 'viewCart'])->name('cart.view');

// rfq


// Show the RFQ form
Route::get('/rfq/create', [RfqController::class, 'create'])->name('rfq.create');

// Handle RFQ submission
Route::post('/rfq/store', [RfqController::class, 'store'])->name('rfq.store');
//partner log in 
use App\Http\Controllers\Auth\PartnerLoginController;
use App\Http\Controllers\Partner\DashboardController;

// Partner Login Routes
Route::get('/partner/login', [PartnerLoginController::class, 'showLoginForm'])->name('partner.login');
Route::post('/partner/login', [PartnerLoginController::class, 'login'])->name('partner.login.submit');

// Partner Dashboard & Logout Routes (protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/partner/dashboard', [DashboardController::class, 'index'])->name('partner.dashboard');
       Route::post('/partner/dashboard/update', [DashboardController::class, 'updateProfile'])->name('partner.profile.update');
    Route::post('/partner/logout', [DashboardController::class, 'logout'])->name('partner.logout');
});

use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Login Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.submit');


// Logout Route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

//email verification
use App\Http\Controllers\Auth\VerifyEmailController;

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/client/dashboard', [DashboardController::class, 'index'])
        ->name('client.dashboard');
  Route::get('/partner/dashboard', [DashboardController::class, 'index'])->name('partner.dashboard');
});



// Route::prefix('partner')->middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('partner.dashboard');
//     Route::post('/dashboard/update', [DashboardController::class, 'updateProfile'])->name('partner.profile.update');
//     Route::post('/logout', [DashboardController::class, 'logout'])->name('partner.logout');
// });


use App\Http\Controllers\Client\ClientController;

// Client Dashboard
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');

    // Profile
    Route::get('/client/profile', [ClientController::class, 'profile'])->name('client.profile');
    Route::post('/client/profile/update', [ClientController::class, 'updateProfile'])->name('client.profile.update');

    // Other pages
    Route::get('/client/subscription', [ClientController::class, 'subscription'])->name('client.subscription');
    Route::get('/client/favourites', [ClientController::class, 'favourites'])->name('client.favourites');
    Route::get('/client/requests', [ClientController::class, 'requests'])->name('client.requests');

    // Logout
    Route::post('/client/logout', [ClientController::class, 'logout'])->name('client.logout');
});

//add favourite 
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CompareController;

Route::middleware(['auth'])->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{product}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{product}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});

// Route::get('/client/favourites', [ClientController::class, 'favourites'])->name('client.favourites');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// // Add a product to comparison
// Route::get('/compare/add/{id}', [App\Http\Controllers\CompareController::class, 'add'])->name('products.compare.add');

// // Remove a product from comparison
// Route::get('/compare/remove/{id}', [App\Http\Controllers\CompareController::class, 'remove'])->name('products.compare.remove');

// // Show comparison page
// // Route::get('/compare', [App\Http\Controllers\CompareController::class, 'index'])
// //     ->name('products.compare.index');

// Route::get('/compare/result', [CompareController::class, 'result'])->name('products.compare.result');
Route::prefix('compare')->group(function () {
    Route::get('/', [CompareController::class, 'index'])->name('products.compare.index');
    Route::get('/add/{id}', [CompareController::class, 'add'])->name('products.compare.add');
    Route::get('/remove/{id}', [CompareController::class, 'remove'])->name('products.compare.remove');
    Route::get('/result', [CompareController::class, 'result'])->name('products.compare.result');
    Route::get('/clear', [CompareController::class, 'clear'])->name('products.compare.clear');
});
