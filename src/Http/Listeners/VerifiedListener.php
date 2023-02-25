<?php

namespace Moez\ActivityLogger\Http\Listeners;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Moez\ActivityLogger\Services\AuthLogService;

class VerifiedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public readonly Request $request) {}

    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        if (!config('user-activity-log.events.auth.verified', false)) return;
        
        (new AuthLogService())->log('verified', $this->request);
        
    }
}
