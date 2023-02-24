<?php

namespace Moez\ActivityLogger\Http\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;
use Moez\ActivityLogger\Services\AuthLogService;

class FailedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public readonly Request $request) {}

    /**
     * Handle the event.
     */
    public function handle(Failed $event): void
    {
        if (!config('user-activity-log.events.auth.failed', false)) return;
        
        $this->request->setUserResolver(function () use ($event) {
            return $event->user;
        });
        
        (new AuthLogService())->log('failed', $this->request);
        
    }
}
