<?php

namespace Moez\ActivityLogger\Http\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;
use Moez\ActivityLogger\Services\AuthLogService;

class LogoutListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public readonly Request $request) {}

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        if (!config('user-activity-log.events.auth.logout', false)) return;
        
        (new AuthLogService())->log('logout', $this->request);
        
    }
}
