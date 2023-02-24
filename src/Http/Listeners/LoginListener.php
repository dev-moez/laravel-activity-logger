<?php

namespace Moez\ActivityLogger\Http\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;
use Moez\ActivityLogger\Services\AuthLogService;

class LoginListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public readonly Request $request){}

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        if (!config('user-activity-log.events.auth.login', false)) return;
        
        (new AuthLogService())->log('login', $this->request);
        
    }
}
