<?php

namespace App\Providers;

use App\Models\CompanyInfo;
use App\Models\LegalPage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share company info and legal pages with all views
        View::composer('*', function ($view) {
            $view->with('company_info', CompanyInfo::query()->latest('id')->first());
            $view->with('active_legal_pages', LegalPage::where('is_active', true)->get());
            $view->with('nav_categories', \App\Models\Category::whereNull('parent_id')->with('children')->orderBy('position')->get());
        });

        $segment = request()->segment(1);

        if ($segment === 'en') {
            app()->setLocale('en');
        } elseif ($segment === 'fr') {
            app()->setLocale('fr');
        } else {
            app()->setLocale('de');
        }
    }
}
