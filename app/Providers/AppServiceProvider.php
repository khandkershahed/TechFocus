<?php

namespace App\Providers;

use Exception;
use App\Models\Admin;
use App\Models\HR\Task;
use App\Models\Admin\Site;
use App\Models\Admin\Brand;
use App\Models\Admin\DynamicCss;
use App\Repositories\FaqRepository;
use App\Repositories\SeoRepository;
use App\Repositories\SmtpRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Repositories\BrandRepository;
use App\Repositories\EventRepository;
use Illuminate\Support\Facades\Schema;
use App\Repositories\AddressRepository;
use App\Repositories\BankingRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\ContactRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use App\Repositories\HrPolicyRepository;
use App\Repositories\IndustryRepository;
use App\Repositories\NewsTrendRepository;
use App\Repositories\VatAndTaxRepository;
use App\Repositories\ProductColorRepository;
use App\Repositories\TermsAndPolicyRepository;
use App\Repositories\DynamicCategoryRepository;
use App\Repositories\SalesTeamTargetRepository;
use App\Repositories\SalesYearTargetRepository;
use App\Repositories\EmployeeCategoryRepository;
use App\Repositories\LeaveApplicationRepository;
use App\Repositories\ProductAttributeRepository;
use App\Repositories\EmployeeDepartmentRepository;
use App\Repositories\PolicyAcknowledgmentRepository;
use App\Repositories\Interfaces\FaqRepositoryInterface;
use App\Repositories\Interfaces\SeoRepositoryInterface;
use App\Repositories\Interfaces\SmtpRepositoryInterface;
use App\Repositories\Interfaces\BrandRepositoryInterface;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\Interfaces\AddressRepositoryInterface;
use App\Repositories\Interfaces\BankingRepositoryInterface;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\ContactRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\HrPolicyRepositoryInterface;
use App\Repositories\Interfaces\IndustryRepositoryInterface;
use App\Repositories\Interfaces\NewsTrendRepositoryInterface;
use App\Repositories\Interfaces\VatAndTaxRepositoryInterface;
use App\Repositories\Interfaces\ProductColorRepositoryInterface;
use App\Repositories\Interfaces\TermsAndPolicyRepositoryInterface;
use App\Repositories\Interfaces\DynamicCategoryRepositoryInterface;
use App\Repositories\Interfaces\SalesTeamTargetRepositoryInterface;
use App\Repositories\Interfaces\SalesYearTargetRepositoryInterface;
use App\Repositories\Interfaces\EmployeeCategoryRepositoryInterface;
use App\Repositories\Interfaces\LeaveApplicationRepositoryInterface;
use App\Repositories\Interfaces\ProductAttributeRepositoryInterface;
use App\Repositories\Interfaces\EmployeeDepartmentRepositoryInterface;
use App\Repositories\Interfaces\PolicyAcknowledgmentRepositoryInterface;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $bindings = [
            PolicyAcknowledgmentRepositoryInterface::class => PolicyAcknowledgmentRepository::class,
            EmployeeDepartmentRepositoryInterface::class => EmployeeDepartmentRepository::class,
            EmployeeCategoryRepositoryInterface::class => EmployeeCategoryRepository::class,
            ProductAttributeRepositoryInterface::class => ProductAttributeRepository::class,
            LeaveApplicationRepositoryInterface::class => LeaveApplicationRepository::class,
            DynamicCategoryRepositoryInterface::class => DynamicCategoryRepository::class,
            SalesYearTargetRepositoryInterface::class => SalesYearTargetRepository::class,
            SalesTeamTargetRepositoryInterface::class => SalesTeamTargetRepository::class,
            TermsAndPolicyRepositoryInterface::class => TermsAndPolicyRepository::class,
            ProductColorRepositoryInterface::class => ProductColorRepository::class,
            VatAndTaxRepositoryInterface::class => VatAndTaxRepository::class,
            NewsTrendRepositoryInterface::class => NewsTrendRepository::class,
            IndustryRepositoryInterface::class => IndustryRepository::class,
            CategoryRepositoryInterface::class => CategoryRepository::class,
            HrPolicyRepositoryInterface::class => HrPolicyRepository::class,
            CompanyRepositoryInterface::class => CompanyRepository::class,
            AddressRepositoryInterface::class => AddressRepository::class,
            ContactRepositoryInterface::class => ContactRepository::class,
            EventRepositoryInterface::class => EventRepository::class,
            BrandRepositoryInterface::class => BrandRepository::class,
            SmtpRepositoryInterface::class => SmtpRepository::class,
            SeoRepositoryInterface::class => SeoRepository::class,
            FaqRepositoryInterface::class => FaqRepository::class,
            BankingRepositoryInterface::class => BankingRepository::class, 
            ProductRepositoryInterface::class=>ProductRepository::class,
        ];

        foreach ($bindings as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    // public function boot()
    // {
    //     View::share('all_employees', null);
    //     View::share('site', null);
    //     View::share('dynamic_css', null);
    //     View::share('agendas', null);

    //     try {
    //         if (Schema::hasTable('admins')) {
    //             View::share('all_employees', Admin::get());
    //         }
    //         if (Schema::hasTable('sites')) {
    //             View::share('site', Site::first());
    //         }
    //         if (Schema::hasTable('dynamic_csses')) {
    //             View::share('dynamic_css', DynamicCss::first());
    //         }
    //         if (Schema::hasTable('tasks')) {
    //             View::share('agendas', Task::where('task_type', 'agenda')->get());
    //         }
    //     } catch (Exception $e) {
    //         // Log the exception if needed
    //     }
    //       // Pass default banner to all views
    // View::composer('*', function ($view) {
    //     $view->with('banner', null); // default null
    // });

    //     Paginator::useBootstrap();
    // }

//     public function boot()
// {
//     View::share('all_employees', null);
//     View::share('site', null);
//     View::share('dynamic_css', null);
//     View::share('agendas', null);

//     try {
//         if (Schema::hasTable('admins')) {
//             View::share('all_employees', Admin::get());
//         }
//         if (Schema::hasTable('sites')) {
//             View::share('site', Site::first());
//         }
//         if (Schema::hasTable('dynamic_csses')) {
//             View::share('dynamic_css', DynamicCss::first());
//         }
//         if (Schema::hasTable('tasks')) {
//             View::share('agendas', Task::where('task_type', 'agenda')->get());
//         }
//     } catch (Exception $e) {
//         // log error if required
//     }

//     // ✅ Share default banner
//     View::composer('*', function ($view) {
//         $view->with('banner', null);
//     });

//     // ✅ Add Pending Brands Count for Sidebar only
//     View::composer('admin.partials.sidebar', function ($view) {
//         $pendingBrandsCount = Brand::where('status', 'pending')->count();
//         $view->with('pendingBrandsCount', $pendingBrandsCount);
//     });

//     Paginator::useBootstrap();
// }
public function boot()
{
    View::share('all_employees', null);
    View::share('site', null);
    View::share('dynamic_css', null);
    View::share('agendas', null);
    View::share('pendingBrandsCount', 0); // Add default value

    try {
        if (Schema::hasTable('admins')) {
            View::share('all_employees', Admin::get());
        }
        if (Schema::hasTable('sites')) {
            View::share('site', Site::first());
        }
        if (Schema::hasTable('dynamic_csses')) {
            View::share('dynamic_css', DynamicCss::first());
        }
        if (Schema::hasTable('tasks')) {
            View::share('agendas', Task::where('task_type', 'agenda')->get());
        }
        
        // Add pending brands count if brands table exists
        if (Schema::hasTable('brands')) {
            $pendingBrandsCount = \App\Models\Admin\Brand::pending()->count();
            View::share('pendingBrandsCount', $pendingBrandsCount);
        }
    } catch (Exception $e) {
        // Log the exception if needed
        View::share('pendingBrandsCount', 0);
    }
    // Share pending products count specifically for admin views
    View::composer(['admin.*', 'admin.layouts.*', 'admin.partials.*'], function ($view) {
        try {
            if (Schema::hasTable('products')) {
                $pendingProductsCount = \App\Models\Admin\Product::pending()->count();
                $view->with('pendingProductsCount', $pendingProductsCount);
            } else {
                $view->with('pendingProductsCount', 0);
            }
        } catch (Exception $e) {
            $view->with('pendingProductsCount', 0);
        }
    });

    // Pass default banner to all views
    View::composer('*', function ($view) {
        $view->with('banner', null); // default null
    });

    Paginator::useBootstrap();
}

}
