<?php
namespace App\Providers;

use App\Models\WebsiteInfo;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share website info with all views
        View::composer('*', function ($view) {
            $websiteInfo = WebsiteInfo::firstOrFail(); // Get the first record of WebsiteInfo
            $view->with('websiteInfo', $websiteInfo);
        });
    }
}