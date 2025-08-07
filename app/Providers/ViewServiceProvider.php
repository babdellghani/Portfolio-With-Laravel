<?php
namespace App\Providers;

use App\Models\WebsiteInfo;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Artisan;
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
            $websiteInfo = WebsiteInfo::first(); // Get the first record of WebsiteInfo
            if (!$websiteInfo) {
                // Run seeder to create default website info
                Artisan::call('db:seed', ['--class' => 'WebsiteInfoSeeder']);
                $websiteInfo = WebsiteInfo::first();
            }
            $view->with('websiteInfo', $websiteInfo);
        });
    }
}