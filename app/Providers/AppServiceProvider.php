<?php

namespace App\Providers;

use App\Policies\ActivityPolicy;
use App\Policies\QueueMonitorPolicy;
use Croustibat\FilamentJobsMonitor\Models\QueueMonitor;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

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

        if (config('app.force_https')) {
            URL::forceScheme('https');
        }
    }
}
