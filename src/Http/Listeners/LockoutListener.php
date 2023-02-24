<?php

namespace Moez\ActivityLogger\Http\Listeners;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Moez\ActivityLogger\Services\AuthLogService;

class LockoutListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public readonly Request $request) {}

    /**
     * Handle the event.
     */
    public function handle(Lockout $event): void
    {
        if (!config('user-activity-log.events.auth.lockout', false)) return;
        
        (new AuthLogService())->log('lockout', $this->request);
    }
}
