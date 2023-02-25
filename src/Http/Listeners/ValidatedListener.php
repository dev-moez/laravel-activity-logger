<?php

namespace Moez\ActivityLogger\Http\Listeners;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Validated;
use Moez\ActivityLogger\Services\AuthLogService;

class ValidatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public readonly Request $request) {}

    /**
     * Handle the event.
     */
    public function handle(Validated $event): void
    {
        if (!config('user-activity-log.events.auth.validated', false)) return;
        
        (new AuthLogService())->log('validated', $this->request);
        
    }
}
