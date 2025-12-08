<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HR\HRController;
use App\Http\Controllers\HR\TaskController;
use App\Http\Controllers\Rfq\RfqController;
use App\Http\Controllers\Rfq\DealController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\RowController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HR\HolidayController;
use App\Http\Controllers\PageBannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\Content\BlogController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\BankingController;
use App\Http\Controllers\Admin\CatalogController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\HR\ProjectKpiController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\HomePageController;
use App\Http\Controllers\Admin\HrPolicyController;
use App\Http\Controllers\Admin\IndustryController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\MovementRecordController;
use App\Http\Controllers\Rfq\RfqProductController;
use App\Http\Controllers\Admin\AboutPageController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BioMetricController;
use App\Http\Controllers\Admin\BrandPageController;
use App\Http\Controllers\Admin\NewsTrendController;
use App\Http\Controllers\Admin\PrincipalController;
use App\Http\Controllers\Admin\ShareLinkController;
use App\Http\Controllers\Admin\VatAndTaxController;
use App\Http\Controllers\HR\EmployeeTaskController;
use App\Http\Controllers\Admin\AdminScopeController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\DynamicCssController;
use App\Http\Controllers\Admin\NewsLetterController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductSasController;
use App\Http\Controllers\Admin\WebSettingController;
use App\Http\Controllers\Site\DynamicSiteController;
use App\Http\Controllers\Admin\ExpenseTypeController;
use App\Http\Controllers\Admin\IndustryPageController;
use App\Http\Controllers\Admin\ProductColorController;
use App\Http\Controllers\Admin\SolutionCardController;
use App\Http\Controllers\HR\EmployeeProjectController;
use App\Http\Controllers\Content\ClientStoryController;
use App\Http\Controllers\Content\TechContentController;
use App\Http\Controllers\HR\LeaveApplicationController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\TermsAndPolicyController;
use App\Http\Controllers\Admin\UserPermissionController;
use App\Http\Controllers\Admin\AccountsPayableController;
use App\Http\Controllers\Admin\DynamicCategoryController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\SolutionDetailsController;
use App\Http\Controllers\Sales\SalesTeamTargetController;
use App\Http\Controllers\Sales\SalesYearTargetController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\CountryStateCityController;
use App\Http\Controllers\Admin\EmployeeCategoryController;
use App\Http\Controllers\Admin\PrincipalAddressController;
use App\Http\Controllers\Admin\PrincipalContactController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\AccountComparisonController;
use App\Http\Controllers\Admin\AccountProfitLossController;
use App\Http\Controllers\Admin\AccountsReceivableController;
use App\Http\Controllers\Admin\EmployeeDepartmentController;
use App\Http\Controllers\Accounts\AccountsDocumentController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\StaffMeetingController;
use App\Http\Controllers\Admin\PolicyAcknowledgmentController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('administrator')->name('admin.')->group(static function () {

    // Guest routes
    Route::middleware('guest:admin')->group(static function () {
        // Auth routes
        Route::get('login', [\App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [\App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'store']);
        // Forgot password
        Route::get('forgot-password', [\App\Http\Controllers\Admin\Auth\PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [\App\Http\Controllers\Admin\Auth\PasswordResetLinkController::class, 'store'])->name('password.email');
        // Reset password
        Route::get('reset-password/{token}', [\App\Http\Controllers\Admin\Auth\NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [\App\Http\Controllers\Admin\Auth\NewPasswordController::class, 'store'])->name('password.update');
    });

    // Verify email routes
    Route::middleware(['auth:admin'])->group(static function () {
        Route::get('verify-email', [\App\Http\Controllers\Admin\Auth\EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', [\App\Http\Controllers\Admin\Auth\VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
        Route::post('email/verification-notification', [\App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');
    });

    // Authenticated routes
    Route::middleware(['auth:admin', 'verified'])->group(static function () {
        // Confirm password routes
        Route::get('confirm-password', [\App\Http\Controllers\Admin\Auth\ConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('confirm-password', [\App\Http\Controllers\Admin\Auth\ConfirmablePasswordController::class, 'store']);
        // Logout route
        Route::post('logout', [\App\Http\Controllers\Admin\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
        // General routes
        Route::get('/dashboard', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('dashboard');
        // Route::get('profile', [\App\Http\Controllers\Admin\HomeController::class, 'profile'])->name('profile');

        Route::get('web-setting', [WebSettingController::class, 'index'])->name('web.setting');
        Route::put('seo-setting', [WebSettingController::class, 'seo'])->name('seo.setting');
        Route::put('smtp-setting', [WebSettingController::class, 'smtp'])->name('smtp.setting');
        Route::put('site/setting', [WebSettingController::class, 'site'])->name('site.setting');

        // Leave
        Route::get('leave-application/history', [LeaveApplicationController::class, 'history'])->name('leave-application.history');
        Route::get('leave-application/dashboard', [LeaveApplicationController::class, 'dashboard'])->name('leave-application.dashboard');

        //Attribute
        Route::controller(AttributeController::class)->group(function () {
            Route::get('/attribute', 'index')->name('attribute.index');
            Route::post('/attribute/store', 'store')->name('attribute.store');
            Route::put('/attribute/{id}/update', 'update')->name('attribute.update');
            Route::delete('/attribute/{id}/destroy', 'destroy')->name('attribute.destroy');
        });
        Route::controller(AttributeValueController::class)->group(function () {
            Route::post('/attribute-value/store', 'store')->name('attribute-value.store');
            Route::post('/attribute-value/update', 'update')->name('attribute-value.update');
            // Route::put('/attribute-value/{id}/update', 'update')->name('attribute-value.updfate');
            Route::delete('/attribute-value/{id}/destroy', 'destroy')->name('attribute-value.destroy');
        });
        // Dynamic CSS
        Route::controller(DynamicCssController::class)->group(function () {
            Route::get('/dynamic-css', 'index')->name('css.index');
            Route::put('/dynamic-css/{id}/update', 'update')->name('css.update');
        });
        //Product
        Route::controller(ProductController::class)->group(function () {
            Route::get('/completed-products', 'index')->name('product.index');
            Route::get('/sourced-products', 'sourcedProducts')->name('sourced.products');
            Route::get('/saved-products', 'savedProducts')->name('saved.products');
            Route::get('/product/create', 'create')->name('product.create');
            Route::post('/product/create', 'store')->name('product.store');
            Route::get('/product/{id}/edit', 'edit')->name('product.edit');
            Route::put('/product/{id}/update', 'update')->name('product.update');
            Route::delete('/product/{id}/destroy', 'destroy')->name('product.destroy');
        });
        // HR
        Route::prefix('hr')->controller(HRController::class)->group(function () {
            Route::get('/dashboard', 'dashboard')->name('hr.dashboard');
        });

        // RFQ
        Route::controller(RfqController::class)->group(function () {
            Route::get('/rfq/list', 'index')->name('rfq.index');
        });
        Route::controller(DealController::class)->group(function () {
            Route::get('/deals/list', 'index')->name('deal.index');
        });

        // Monthly tasks
        Route::get('/employee/monthly-tasks/{employeeId}', [EmployeeTaskController::class, 'employeeTasks'])->name('monthly.tasks');


        Route::resources(
            [
                // 'product'          => ProductController::class,
                'product-sas'      => ProductSasController::class,
                'brand-page'       => BrandPageController::class,
                'solution-details' => SolutionDetailsController::class,
                'industry-page'    => IndustryPageController::class,
                'industry'         => IndustryController::class,
                'row'              => RowController::class,
                'homepage'         => HomePageController::class, 
                'aboutpage'        => AboutPageController::class, 
                'solution-card'    => SolutionCardController::class,
                'employee'         => EmployeeController::class,
                'employee-project' => EmployeeProjectController::class,
                'project-kpi'      => ProjectKpiController::class,
                'catalog'          => CatalogController::class,
                'banner'           => BannerController::class,
                'employee-task'    => EmployeeTaskController::class,
                'task'             => TaskController::class,
                'dynamic-site'     => DynamicSiteController::class,
            ]
        );
        Route::resources(
            [
                'profile'               => ProfileController::class,
                'vat-tax'               => VatAndTaxController::class,
                'employee-category'     => EmployeeCategoryController::class,
                'employee-department'   => EmployeeDepartmentController::class,
                'category'              => CategoryController::class,
                'brand'                 => BrandController::class,
                'product-attribute'     => ProductAttributeController::class,
                'product-color'         => ProductColorController::class,
                'company'               => CompanyController::class,
                'address'               => AddressController::class,
                'leave-application'     => LeaveApplicationController::class,
                'dynamic-category'      => DynamicCategoryController::class,
                'event'                 => EventController::class,
                'faq'                   => FaqController::class,
                'sales-year-target'     => SalesYearTargetController::class,
                'sales-team-target'     => SalesTeamTargetController::class,
                'news-trend'            => NewsTrendController::class,
                'hr-policy'             => HrPolicyController::class,
                'policy-acknowledgment' => PolicyAcknowledgmentController::class,
                'terms-and-policy'      => TermsAndPolicyController::class,
                'banking'               => BankingController::class,
                'holiday'               => HolidayController::class,
                'attendance'            => AttendanceController::class, //not my work
                'accounts-document'     => AccountsDocumentController::class,
                'currency'              => CurrencyController::class,
                // 'movement'              => MovementRecordController::class, 
            ],
            ['except' => ['create', 'show', 'edit'],]
        );
        Route::resources(
            [
                'blog'         => BlogController::class,
                'story'        => ClientStoryController::class,
                'tech-content' => TechContentController::class,

            ],
            ['except' => ['store', 'update', 'show'],]
        );

        // Route::resource('contact', ContactController::class)->except(['create', 'show', 'edit'])
        //     ->middleware(['throttle:10,1', 'checkBan'], 'only', ['store']);

        Route::get('country-state-city', [CountryStateCityController::class, 'index'])->name('country.state.city.index');

        Route::put('country/{id}/update', [CountryStateCityController::class, 'updateCountry'])->name('country.update');
        Route::delete('country/{id}/destroy', [CountryStateCityController::class, 'destroyCountry'])->name('country.destroy');

        Route::put('state/{id}/update', [CountryStateCityController::class, 'updateState'])->name('state.update');
        Route::delete('state/{id}/destroy', [CountryStateCityController::class, 'destroyState'])->name('state.destroy');

        Route::put('city/{id}/update', [CountryStateCityController::class, 'updateCity'])->name('city.update');
        Route::delete('city/{id}/destroy', [CountryStateCityController::class, 'destroyCity'])->name('city.destroy');

        Route::resource('company', CompanyController::class)->except(['show']); // dd uncommitted changes
        Route::resource('news-trend', NewsTrendController::class)->except(['show']); // dd uncommitted changes

        Route::resource('role', RoleController::class);
        Route::resource('permission', PermissionController::class);


        // Route to display the role permission management page
        // Assuming you have a method in your controller to show the page
        Route::get('/role/{role}/permission', [RolePermissionController::class, 'show'])
            ->name('role-permission.show');

        // Route to assign a permission to a role
        Route::post('/role/{role}/permission/assign', [RolePermissionController::class, 'assignPermission'])
            ->name('role-permission.assign');

        // Route to remove a permission from a role
        Route::delete('/role/{role}/permission/{permission}', [RolePermissionController::class, 'removePermission'])
            ->name('role-permission.remove');

        // Route to display form for assigning permission to a user
        Route::get('/user/{user}/permission/create', [UserPermissionController::class, 'create'])
            ->name('user-permission.create');

        // Route to store the assigned permission for a user
        Route::post('/user/{user}/permission', [UserPermissionController::class, 'store'])
            ->name('user-permission.store');

        // Route to display form for removing permission from a user
        Route::get('/user/{user}/permission/edit', [UserPermissionController::class, 'edit'])
            ->name('user-permission.edit');

        // Route to remove a specific permission from a user
        Route::delete('/user/{user}/permission/{permission}', [UserPermissionController::class, 'destroy'])
            ->name('user-permission.destroy');


        // Display a listing of the admins with their roles
        Route::get('/user-roles', [UserRoleController::class, 'index'])
            ->name('user-roles.index');

        // Show the form for assigning a role to an admin
        Route::get('/user-roles/{user}/edit', [UserRoleController::class, 'edit'])
            ->name('user-roles.edit');

        // Update the specified admin's roles
        Route::put('/user-roles/{user}', [UserRoleController::class, 'update'])
            ->name('user-roles.update');

        // Remove the specified role from the admin
        Route::delete('/user-roles/{user}/role/{role}', [UserRoleController::class, 'destroy'])
            ->name('user-roles.destroy');
    });

    // Route::get('/subscribers', [NewsletterController::class, 'index'])->name('newsletter.index');
    // Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

    // Route::get('/verify/{token}', [NewsletterController::class, 'verify'])->name('newsletter.verify');

    Route::get('/verified', function () {
        return view('newsletter.verified');
    })->name('newsletter.verified');

    Route::get('/verify-failed', function () {
        return view('newsletter.verify-failed');
    })->name('newsletter.verify-failed');

    // Route::post('/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');


    // Route::resource('example', ExampleController::class)->except(['create', 'show', 'edit']); //example

    Route::get('/machine-devicesetip-index', [BioMetricController::class, 'index'])->name('attendance.dashboard');
    // Route::get('/attendance-data/single/{id}', [BioMetricController::class, 'attendanceDataSingle'])->name('attendance.single');
    Route::post('/device-setip', [BioMetricController::class, 'device_setip'])->name('machine.devicesetip');
    // Route::get('/device-information', [BioMetricController::class, 'device_information'])->name('machine.deviceinformation');
    // Route::get('/device-user-data', [BioMetricController::class, 'device_user_data'])->name('machine.deviceuserdata');
    // Route::get('/device-attendance-data', [BioMetricController::class, 'device_attendance_data'])->name('machine.deviceattendancedata');
    // Route::get('/device-adduser', [BioMetricController::class, 'device_adduser'])->name('machine.deviceadduser');
    // Route::post('/device-setuser', [BioMetricController::class, 'device_setuser'])->name('machine.devicesetuser');
    // Route::get('/device-removeuser-single/{id}', [BioMetricController::class, 'device_removeuser_single'])->name('machine.deviceremoveusersingle');
    // Route::get('/device-viewuser-single/[id]', [BioMetricController::class, 'device_viewuser_single'])->name('machine.deviceviewusersingle');
    // Route::get('/device-data/clear-attendance', [BioMetricController::class, 'device_data_clear_attendance'])->name('machine.devicedata.clear.attendance');
    // Route::get('/device-restart', [BioMetricController::class, 'device_restart'])->name('machine.devicerestart');
    // Route::get('/device-shutdown', [BioMetricController::class, 'device_shutdown'])->name('machine.deviceshutdown');
});



Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    // List
    Route::get('page-banners', [PageBannerController::class, 'index'])->name('page_banners.index');

    // Create
    Route::get('page-banners/create', [PageBannerController::class, 'create'])->name('page_banners.create');
    Route::post('page-banners', [PageBannerController::class, 'store'])->name('page_banners.store');

    // Edit / Update
    Route::get('page-banners/{pageBanner}/edit', [PageBannerController::class, 'edit'])->name('page_banners.edit');
    Route::put('page-banners/{pageBanner}', [PageBannerController::class, 'update'])->name('page_banners.update');

    // Delete
    Route::delete('page-banners/{pageBanner}', [PageBannerController::class, 'destroy'])->name('page_banners.destroy');
      Route::resource('rfqProducts', RfqProductController::class);
});



// Admin Employee Task Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Resource routes for EmployeeTask (except 'show')
    Route::resource('employee-task', EmployeeTaskController::class)->except(['show']);

    // Get all tasks for a selected employee (AJAX)
    Route::get('employee-tasks/{employeeId}', [EmployeeTaskController::class, 'employeeTasks'])->name('employee.tasks');

    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/create', [CatalogController::class, 'create'])->name('catalog.create');
Route::post('/catalog', [CatalogController::class, 'store'])->name('catalog.store');
Route::get('/catalog/{id}/edit', [CatalogController::class, 'edit'])->name('catalog.edit');
Route::put('/catalog/{id}', [CatalogController::class, 'update'])->name('catalog.update');
Route::delete('/catalog/{id}', [CatalogController::class, 'destroy'])->name('catalog.destroy');

});


//leave
// Leave Application Routes
Route::prefix('leave-applications')->name('leave-applications.')->group(function () {
    
    // Index/List Route
    Route::get('/', [LeaveApplicationController::class, 'index'])->name('index');
        Route::get('/create', [LeaveApplicationController::class, 'create'])->name('create'); 
    
    // History Route
    Route::get('/history', [LeaveApplicationController::class, 'history'])->name('history');
    
    // Dashboard Route
    Route::get('/dashboard', [LeaveApplicationController::class, 'dashboard'])->name('dashboard');
    
    // Store Route
    Route::post('/store', [LeaveApplicationController::class, 'store'])->name('store');
    
    // Edit Route
    Route::get('/edit/{id}', [LeaveApplicationController::class, 'edit'])->name('edit');
    
    // Update Route
    Route::put('/update/{id}', [LeaveApplicationController::class, 'update'])->name('update');
    
    // Delete Route
    Route::delete('/destroy/{id}', [LeaveApplicationController::class, 'destroy'])->name('destroy');
});

// Alternative shorter routes if preferred:
Route::resource('leave-applications', LeaveApplicationController::class)->except(['show', 'create']);
Route::get('leave-applications/history', [LeaveApplicationController::class, 'history'])->name('leave-applications.history');
Route::get('leave-applications/dashboard', [LeaveApplicationController::class, 'dashboard'])->name('leave-applications.dashboard');

//catalog 

// OR


// ✅ RFQ Product Routes
Route::prefix('admin')->group(function () {
    Route::resource('rfqProducts', RfqProductController::class);
});
Route::resource('company', CompanyController::class)->except(['show']);

//faQ routes
Route::prefix('administrator')->name('admin.')->group(function () {
    // List all FAQs
    Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

    // Store a new FAQ (from modal form)
    Route::post('/faq', [FaqController::class, 'store'])->name('faq.store');

    // Update an existing FAQ (from modal form)
    Route::put('/faq/{id}', [FaqController::class, 'update'])->name('faq.update');

    // Delete an FAQ
    Route::delete('/faq/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');

    // Optional: Search FAQs
    Route::get('/faq/search', [FaqController::class, 'search'])->name('faq.search');
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/profile/edit', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::post('/profile/update', [App\Http\Controllers\Admin\ProfileController::class, 'update'])
        ->name('profile.update');
});


//client story
Route::prefix('admin')->group(function () {
    Route::resource('story', ClientStoryController::class);
    // Or individually:
    Route::get('/story', [ClientStoryController::class, 'index'])->name('admin.story.index');
    Route::get('/story/create', [ClientStoryController::class, 'create'])->name('admin.story.create');
    Route::post('/story', [ClientStoryController::class, 'store'])->name('admin.story.store');
    Route::get('/story/{id}/edit', [ClientStoryController::class, 'edit'])->name('admin.story.edit');
    Route::put('/story/{id}', [ClientStoryController::class, 'update'])->name('admin.story.update');
    Route::delete('/story/{id}', [ClientStoryController::class, 'destroy'])->name('admin.story.destroy');
});

// Blog Routes
Route::prefix('blogs')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blogs.index');
    Route::get('/create', [BlogController::class, 'create'])->name('blogs.create');
    Route::post('/', [BlogController::class, 'store'])->name('blogs.store');
    Route::get('/{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/{id}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy');
});

// Or using resource route (shorter version)
Route::resource('blogs', BlogController::class)->except(['show']);

Route::post('/product/delete-image', [ProductController::class, 'deleteImage'])
    ->name('product.deleteImage');



// Frontend newsletter subscription
Route::post('/newsletter/subscribe', [NewsLetterController::class, 'subscribe'])->name('newsletter.subscribe');

// Admin routes
Route::prefix('admin')->group(function () {
    // Newsletter list page
    Route::get('newsletter', [NewsLetterController::class, 'index'])->name('newsletter.index');
    // Delete subscriber
    Route::delete('newsletter/{id}', [NewsLetterController::class, 'destroy'])->name('admin.newsletter.destroy');
});
//admin principal
// Admin Principal Management Routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'verified'])->group(function () {
    Route::get('principals', [PrincipalController::class, 'index'])->name('principals.index');
    Route::get('principals/{principal}', [PrincipalController::class, 'show'])->name('principals.show');
    Route::patch('principals/{principal}/status', [PrincipalController::class, 'updateStatus'])->name('principals.update-status');
    Route::get('principals-stats', [PrincipalController::class, 'getStats'])->name('principals.stats');
});

// Admin Brand Management Routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    // ... other routes
    
    // Brand Routes
    Route::get('/brands/pending', [BrandController::class, 'pending'])->name('brands.pending');
    Route::post('/brands/{id}/approve', [BrandController::class, 'approve'])->name('brands.approve');
    Route::post('/brands/{id}/reject', [BrandController::class, 'reject'])->name('brands.reject');
    Route::resource('brands', BrandController::class);
});

// Admin Product Routes
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    // ... other routes
    
    // Product Routes
    Route::get('/products/pending', [ProductController::class, 'pending'])->name('products.pending');
    Route::post('/products/{id}/approve', [ProductController::class, 'approve'])->name('products.approve');
    Route::post('/products/{id}/reject', [ProductController::class, 'reject'])->name('products.reject');
    Route::resource('products', ProductController::class);
});

Route::prefix('administrator')->name('admin.')->middleware(['auth:admin', 'verified'])->group(function () {
    Route::get('pages/contact', [ContactController::class, 'index'])->name('pages.contact.index');
    Route::get('pages/contact/show/{id}', [ContactController::class, 'show'])->name('pages.contact.show');
    Route::put('pages/contact/{id}', [ContactController::class, 'update'])->name('pages.contact.update');
    Route::delete('pages/contact/{id}', [ContactController::class, 'destroy'])->name('pages.contact.destroy');
});
Route::delete('/admin/pages/contact/bulk-delete', [ContactController::class, 'bulkDelete'])
    ->name('admin.pages.contact.bulkDelete');

Route::delete('/admin/pages/contact/delete-all', [ContactController::class, 'deleteAll'])
    ->name('admin.pages.contact.deleteAll');


//catagory section 
    // Category Index (listing)
    Route::get('categories', [CategoryController::class, 'index'])->name('category.index');

    // Store new category
    Route::post('categories', [CategoryController::class, 'store'])->name('category.store');

    // Edit category (load modal or page)
    // Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('category', CategoryController::class);
});

    // Update category
    Route::put('categories/{id}', [CategoryController::class, 'update'])->name('category.update');

    // Delete category
     Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');


    // Optional: For AJAX status toggle or bulk actions
    Route::post('categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('category.bulkDelete');

    Route::prefix('admin/principals')->name('admin.principals.')->group(function () {
    Route::patch('{principal}/update-status', [PrincipalController::class, 'updateStatus'])->name('update-status');

    Route::post('{principal}/contacts', [PrincipalContactController::class, 'store'])->name('contacts.store');
    Route::patch('contacts/{contact}', [PrincipalContactController::class, 'update'])->name('contacts.update');
    Route::delete('contacts/{contact}', [PrincipalContactController::class, 'destroy'])->name('contacts.destroy');

    Route::post('{principal}/addresses', [PrincipalAddressController::class, 'store'])->name('addresses.store');
});
Route::delete('/admin/principals/{principal}', [PrincipalController::class, 'destroy'])
    ->name('admin.principals.destroy');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('roles/{role}/permissions', [RolePermissionController::class, 'show'])
         ->name('role-permissions.show');
});
Route::prefix('admin')->name('admin.')->group(function () {

    //Assign/update permissions to a role
    Route::post('roles/{role}/permissions', [RolePermissionController::class, 'assignPermission'])
         ->name('role-permissions.assign');
});

// Admin Principal Links Routes
Route::prefix('admin/principals/{principal}/links')->name('admin.principals.links.')->group(function () {
    Route::get('/', [PrincipalContactController::class, 'index'])->name('index');
    Route::get('/{link}', [PrincipalContactController::class, 'show'])->name('show');
    Route::delete('/{link}', [PrincipalContactController::class, 'destroy'])->name('destroy');
});




Route::prefix('admin')->name('admin.')->group(function () {


    // Admin middleware group - requires admin authentication
    Route::middleware(['auth:admin'])->group(function () {
        
        // Role scopes management
        Route::get('roles/{role}/scopes', [AdminScopeController::class, 'edit'])
             ->name('role-scopes.edit');
        Route::put('roles/{role}/scopes', [AdminScopeController::class, 'update'])
             ->name('role-scopes.update');

        // Principals with scoped access
        Route::resource('principals', PrincipalController::class)->middleware([
            'scoped.access:principal'
        ]);

        // Share links management
        Route::prefix('principals/{principal}/links')->name('principals.links.')->group(function () {
            Route::get('create', [ShareLinkController::class, 'create'])->name('create');
            Route::post('/', [ShareLinkController::class, 'store'])->name('store');
            Route::delete('/{link}', [ShareLinkController::class, 'destroy'])->name('destroy');
        });

        // // Admin dashboard
        // Route::get('/dashboard', function () {
        //     return view('admin.dashboard');
        // })->name('dashboard');

        // Add other admin routes here...
    });
});

// Public share links (no auth required)
Route::prefix('share')->name('share.links.')->group(function () {
    Route::get('/{token}', [ShareLinkController::class, 'show'])
         ->middleware('share.link')
         ->name('show');
});

// // Optional: Redirect root to admin dashboard if needed
// // Route::get('/', function () {
// //     return redirect()->route('admin.dashboard');
// });

Route::prefix('admin')->name('admin.')->group(function () {
    // Admin middleware group
    Route::middleware(['auth:admin'])->group(function () {
        
        // Role permissions management
        Route::prefix('roles/{role}/permissions')->name('role-permissions.')->group(function () {
            Route::get('/', [RolePermissionController::class, 'show'])->name('show');
            Route::post('/', [RolePermissionController::class, 'assignPermission'])->name('assign');
            Route::delete('/{permission}', [RolePermissionController::class, 'removePermission'])->name('remove'); // ← Add this line
        });

        // Role scopes management
        Route::get('roles/{role}/scopes', [AdminScopeController::class, 'edit'])
             ->name('role-scopes.edit');
        Route::put('roles/{role}/scopes', [AdminScopeController::class, 'update'])
             ->name('role-scopes.update');

        // Principals with scoped access
        Route::resource('principals', PrincipalController::class)->middleware([
            'scoped.access:principal'
        ]);

        // Share links management
        Route::prefix('principals/{principal}/links')->name('principals.links.')->group(function () {
            Route::get('create', [ShareLinkController::class, 'create'])->name('create');
            Route::post('/', [ShareLinkController::class, 'store'])->name('store');
            Route::delete('/{link}', [ShareLinkController::class, 'destroy'])->name('destroy');
        });

        // // Admin dashboard
        // Route::get('/dashboard', function () {
        //     return view('admin.dashboard');
        // })->name('dashboard');
    });
});

// Public share links
Route::prefix('share')->name('share.links.')->group(function () {
    Route::get('/{token}', [ShareLinkController::class, 'show'])
         ->middleware('share.link')
         ->name('show');
});

//role user
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth:admin'])->group(function () {
        
        // User Management
        Route::resource('users', UserController::class);
        
        // Existing routes...
        Route::resource('roles', RoleController::class);
        Route::resource('principals', PrincipalController::class);
        
        // Role Permissions Management
        Route::prefix('roles/{role}/permissions')->name('role-permissions.')->group(function () {
            Route::get('/', [RolePermissionController::class, 'show'])->name('show');
            Route::post('/', [RolePermissionController::class, 'assignPermission'])->name('assign');
        });
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth:admin'])->group(function () {
        
        // User Permissions Management
        Route::prefix('user-permissions')->name('user-permission.')->group(function () {
            Route::get('/', [UserPermissionController::class, 'index'])->name('index');
            Route::get('/{userId}/create', [UserPermissionController::class, 'create'])->name('create');
            Route::post('/{userId}', [UserPermissionController::class, 'store'])->name('store');
            Route::get('/{userId}/edit', [UserPermissionController::class, 'edit'])->name('edit');
            Route::delete('/{userId}/{permissionId}', [UserPermissionController::class, 'destroy'])->name('destroy');
        });
        
        // Your existing routes...
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth:admin'])->group(function () {
        
        // Permission Management Routes
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
        
        
    });
});

//acount modeul 


// Admin Routes Group
Route::prefix('admin')->name('admin.')->group(function () {
 // Resource Routes
    Route::resource('expense-categories', ExpenseCategoryController::class);
    Route::resource('expense-types', ExpenseTypeController::class);
    Route::resource('bankings', BankingController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('accounts-receivables', AccountsReceivableController::class);
    Route::resource('incomes', IncomeController::class);
    Route::resource('account-profit-losses', AccountProfitLossController::class);
    Route::resource('accounts-payables', AccountsPayableController::class);
    Route::get('/account-dashboard', [AccountController::class, 'dashboard'])->name('account.dashboard');

    // Additional route for dynamic dropdown
    // Route::get('/expense-types-by-category/{categoryId}', [ExpenseController::class, 'getTypesByCategory'])->name('expense-types.by-category');
        // Additional route for dynamic expense type dropdown
  Route::get('/expense-types-by-category/{categoryId}', [ExpenseController::class, 'getTypesByCategory'])
    ->name('expenses.types.by-category');
   
});
 Route::get('/account-comparison', [AccountComparisonController::class, 'comparison'])->name('account.comparison');
// Add this inside the admin prefix group

// Admin routes for share links
// Route::prefix('admin/principals/{principal}/share-links')->name('admin.principals.share-links.')->group(function () {
//     Route::get('/', [ShareLinkController::class, 'index'])->name('index');
//     Route::get('/create', [ShareLinkController::class, 'create'])->name('create');
//     Route::post('/', [ShareLinkController::class, 'store'])->name('store');
//     Route::delete('/{shareLink}', [ShareLinkController::class, 'destroy'])->name('destroy');
// });

Route::prefix('admin/principals/{principal}/share-links')->name('admin.principals.share-links.')->group(function () {
    Route::get('/', [ShareLinkController::class, 'index'])->name('index');
    Route::get('/create', [ShareLinkController::class, 'create'])->name('create');
    Route::post('/', [ShareLinkController::class, 'store'])->name('store');
    Route::get('/{shareLink}/copy', [ShareLinkController::class, 'copyLink'])->name('copy');
    Route::delete('/{shareLink}', [ShareLinkController::class, 'destroy'])->name('destroy');
});

Route::get('/guest/share/{token}', [ShareLinkController::class, 'show'])->name('guest.share-links.show');
Route::get('/admin/get-rfq-details/{id}', [AccountsReceivableController::class, 'getRfqDetails']);
Route::get('/admin/accounts-receivables/{id}/download-client-po', [App\Http\Controllers\Admin\AccountsReceivableController::class, 'downloadClientPo'])->name('admin.accounts-receivables.download-client-po');
Route::get('/admin/accounts-receivables/{id}/download-invoice', [App\Http\Controllers\Admin\AccountsReceivableController::class, 'downloadInvoice'])->name('admin.accounts-receivables.download-invoice');
// Admin note routes
Route::post('/admin/principals/{principal}/notes/{activity}/reply', [PrincipalController::class, 'storeReply'])->name('admin.principals.notes.reply');
Route::post('/admin/principals/{principal}/notes/{activity}/pin', [PrincipalController::class, 'togglePin'])->name('admin.principals.notes.pin');
Route::delete('/admin/principals/{principal}/notes/{activity}', [PrincipalController::class, 'deleteNote'])->name('admin.principals.notes.delete');


// Route::resource('movement', \App\Http\Controllers\Admin\MovementRecordController::class)->names([
//     'index' => 'admin.movement.index',
//     'create' => 'admin.movement.create',
//     'store' => 'admin.movement.store',
//     'show' => 'admin.movement.show',
//     'edit' => 'admin.movement.edit',
//     'update' => 'admin.movement.update',
//     'destroy' => 'admin.movement.destroy',
// ]);
// In your routes file
Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    
    // Movement routes
    Route::prefix('movement')->name('admin.movement.')->group(function () {
        Route::get('/edit-requests', [MovementRecordController::class, 'editRequests'])
            ->name('edit-requests');
        
        Route::post('/{id}/approve-edit', [MovementRecordController::class, 'approveEdit'])
            ->name('approve-edit');
        
        Route::post('/{id}/reject-edit', [MovementRecordController::class, 'rejectEdit'])
            ->name('reject-edit');
        
        // Your existing CRUD routes
        Route::get('/', [MovementRecordController::class, 'index'])->name('index');
        Route::get('/create', [MovementRecordController::class, 'create'])->name('create');
        Route::post('/', [MovementRecordController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MovementRecordController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MovementRecordController::class, 'update'])->name('update');
        Route::delete('/{id}', [MovementRecordController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [MovementRecordController::class, 'show'])->name('show');

    });
});

// // routes/web.php or routes/admin.php
// Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    
//     // Movement routes
//     Route::prefix('movement')->group(function () {
//         Route::get('/edit-requests', [MovementRecordController::class, 'editRequests'])
//             ->name('admin.movement.edit-requests');
        
//         Route::post('/{id}/approve-edit', [MovementRecordController::class, 'approveEdit'])
//             ->name('admin.movement.approve-edit');
        
//         Route::post('/{id}/reject-edit', [MovementRecordController::class, 'rejectEdit'])
//             ->name('admin.movement.reject-edit');
       
//     });
// });

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    
    // Movement routes - HR Dashboard FIRST
    Route::prefix('movement')->name('admin.movement.')->group(function () {
        // HR Dashboard Route
        // Route::get('/hr-dashboard', [MovementRecordController::class, 'hrDashboard'])
        //     ->name('hr-dashboard');
    });
    
    // Movement routes - Edit Requests
    Route::prefix('movement')->name('admin.movement.')->group(function () {
        Route::get('/edit-requests', [MovementRecordController::class, 'editRequests'])
            ->name('edit-requests');
        
        Route::post('/{id}/approve-edit', [MovementRecordController::class, 'approveEdit'])
            ->name('approve-edit');
        
        Route::post('/{id}/reject-edit', [MovementRecordController::class, 'rejectEdit'])
            ->name('reject-edit');
    });
    
 
});
        Route::get('/staff-dashboard', [MovementRecordController::class, 'staffDashboard'])
    ->name('staff.dashboard');

// Admin Routes Group
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    
    // Staff Meetings Routes
    Route::prefix('staff-meetings')->name('staff-meetings.')->group(function () {
        Route::get('/', [StaffMeetingController::class, 'index'])->name('index');
        Route::get('/create', [StaffMeetingController::class, 'create'])->name('create');
        Route::post('/', [StaffMeetingController::class, 'store'])->name('store');
        Route::get('/{staffMeeting}', [StaffMeetingController::class, 'show'])->name('show');
        Route::get('/{staffMeeting}/edit', [StaffMeetingController::class, 'edit'])->name('edit');
        Route::put('/{staffMeeting}', [StaffMeetingController::class, 'update'])->name('update');
        Route::delete('/{staffMeeting}', [StaffMeetingController::class, 'destroy'])->name('destroy');
        
        // Additional routes
        Route::post('/{staffMeeting}/status', [StaffMeetingController::class, 'updateStatus'])->name('update-status');
        Route::get('/export', [StaffMeetingController::class, 'export'])->name('export');
        
        // Filter routes
        Route::get('/status/{status}', [StaffMeetingController::class, 'filterByStatus'])->name('filter.status');
        Route::get('/upcoming', [StaffMeetingController::class, 'upcoming'])->name('upcoming');
        Route::get('/today', [StaffMeetingController::class, 'today'])->name('today');
        Route::get('/month/{month?}', [StaffMeetingController::class, 'byMonth'])->name('by-month');
        Route::get('/department/{department}', [StaffMeetingController::class, 'byDepartment'])->name('by-department');
    });
    
});

Route::get('/calendar', [StaffMeetingController::class, 'calendar'])->name('admin.staff-meetings.calendar');
 Route::get('/calendar-data', [StaffMeetingController::class, 'calendarData'])->name('admin.staff-meetings.calendar.data');
 


   
        
