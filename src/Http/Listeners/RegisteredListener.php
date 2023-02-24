<?php

namespace Moez\ActivityLogger\Http\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;
use Moez\ActivityLogger\Services\AuthLogService;
use Illuminate\Auth\Events\Registered;

class RegisteredListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public readonly Request $request) {}

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        
        if (!config('user-activity-log.events.auth.register', false)) return;
        
        $this->request->setUserResolver(function () use ($event) {
            return $event->user;
        });
        
        (new AuthLogService())->log('register', $this->request);
        
    }
}
