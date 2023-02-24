<?php

namespace Moez\ActivityLogger\Providers;

use Illuminate\Support\ServiceProvider;

class ActivityLoggerProvider extends ServiceProvider
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
        $this->loadRoutesFrom(__DIR__.'../../routes/web.php');
        // $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->publishes([
            __DIR__.'/../../config/user-activity-log.php' => config_path('user-activity-log.php')
        ], 'user-activity-log-config');
     
        $this->publishes([
            __DIR__.'/../../database/migrations/' => database_path('migrations')
        ], 'user-activity-log-migrations');

        $this->app->register(EventServiceProvider::class);
    }
}
