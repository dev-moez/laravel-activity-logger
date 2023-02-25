<?php

namespace Moez\ActivityLogger\Providers;

use Moez\ActivityLogger\Http\Listeners\LoginListener;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Moez\ActivityLogger\Http\Listeners\LockoutListener;
use Moez\ActivityLogger\Http\Listeners\RegisteredListener;
use Illuminate\Auth\Events\Logout;
use Moez\ActivityLogger\Http\Listeners\LogoutListener;
use Illuminate\Auth\Events\PasswordReset;
use Moez\ActivityLogger\Http\Listeners\PasswordResetListener;
use Illuminate\Auth\Events\Failed;
use Moez\ActivityLogger\Http\Listeners\FailedListener;
use Illuminate\Auth\Events\Attempting;
use Moez\ActivityLogger\Http\Listeners\AttemptingListener;
use Illuminate\Auth\Events\CurrentDeviceLogout;
use Illuminate\Auth\Events\OtherDeviceLogout;
use Illuminate\Auth\Events\Validated;

class EventServiceProvider extends ServiceProvider
{
    
    protected $listen = [
        // Login event listener
        Login::class => [
            LoginListener::class,
        ],

        // Registered new user event listener
        Registered::class => [
            RegisteredListener::class
        ],
        
        // Lockout due to many login attempts event listener
        Lockout::class => [
            LockoutListener::class
        ],

        // Logout event listener
        Logout::class => [
            LogoutListener::class
        ],

        // Password reset event listener
        PasswordReset::class => [
            PasswordResetListener::class
        ],

        // Failed to authenticate event listener
        Failed::class => [
            FailedListener::class
        ],

        // Attempt to login event listener
        Attempting::class => [
            AttemptingListener::class
        ],

        // Current device logout event listener
        CurrentDeviceLogout::class => [
            CurrentDeviceLogoutListener::class,
        ],
        
        // Other device logout event listener
        OtherDeviceLogout::class => [
            OtherDeviceLogoutListener::class,
        ],

        // Validated event listener: when a user validated his email address
        Validated::class => [
            ValidatedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        
    }
}
