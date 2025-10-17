<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ProgressReport;
use App\Observers\ProgressReportObserver;

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
        // Register model observers for cache invalidation
        ProgressReport::observe(ProgressReportObserver::class);
    }
}
