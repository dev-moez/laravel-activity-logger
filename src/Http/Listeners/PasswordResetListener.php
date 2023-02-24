<?php

namespace Moez\ActivityLogger\Http\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;
use Moez\ActivityLogger\Services\AuthLogService;

class PasswordResetListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public readonly Request $request) {}

    /**
     * Handle the event.
     */
    public function handle(PasswordReset $event): void
    {
        if (!config('user-activity-log.events.auth.password_reset', false)) return;
        
        $this->request->setUserResolver(function () use ($event) {
            return $event->user;
        });
        
        (new AuthLogService())->log('password_reset', $this->request);
        
    }
}
