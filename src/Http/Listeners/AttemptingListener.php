<?php

namespace Moez\ActivityLogger\Http\Listeners;

use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;
use Moez\ActivityLogger\Services\AuthLogService;
use Illuminate\Support\Facades\Auth;

class AttemptingListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public readonly Request $request) {}

    /**
     * Handle the event.
     */
    public function handle(Attempting $event): void
    {
        if (!config('user-activity-log.events.auth.attempting', false)) return;
        
        $this->request->setUserResolver(function () use ($event) {
            $provider = config('auth.guards.'.$event->guard.'.provider');
            $authModel = config('auth.providers.'.$provider.'.model');
            $user = app($authModel)->where('email', $event->credentials['email'])->first();
            return $user;
        });
        
        (new AuthLogService())->log('attempting', $this->request);
        
    }
}
