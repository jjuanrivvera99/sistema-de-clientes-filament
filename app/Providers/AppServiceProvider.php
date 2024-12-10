<?php

namespace App\Providers;

use App\Policies\ActivityPolicy;
use Illuminate\Support\Facades\URL;
use App\Policies\QueueMonitorPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use Croustibat\FilamentJobsMonitor\Models\QueueMonitor;

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
        Gate::policy(Activity::class, ActivityPolicy::class);
        Gate::policy(QueueMonitor::class, QueueMonitorPolicy::class);
    
        if (env('FORCE_HTTPS')) {
            URL::forceScheme('https');
        }
    }
}
