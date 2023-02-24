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

class EventServiceProvider extends ServiceProvider
{
    
    protected $listen = [
        // User has logged in
        Login::class => [
            LoginListener::class,
        ],

        // User has registered
        Registered::class => [
            RegisteredListener::class
        ],
        
        // User has been locked out due to many login attempts
        Lockout::class => [
            LockoutListener::class
        ],

        // User has logged out
        Logout::class => [
            LogoutListener::class
        ],

        // User has reset his password
        PasswordReset::class => [
            PasswordResetListener::class
        ],

        // Authentication failed
        Failed::class => [
            FailedListener::class
        ],

        Attempting::class => [
            AttemptingListener::class
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        
    }
}
