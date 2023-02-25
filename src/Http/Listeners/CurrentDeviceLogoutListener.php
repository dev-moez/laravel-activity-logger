<?php

namespace Moez\ActivityLogger\Http\Listeners;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\CurrentDeviceLogout;
use Moez\ActivityLogger\Services\AuthLogService;

class CurrentDeviceLogoutListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public readonly Request $request) {}

    /**
     * Handle the event.
     */
    public function handle(CurrentDeviceLogout $event): void
    {
        if (!config('user-activity-log.events.auth.current_device_logout', false)) return;
        
        (new AuthLogService())->log('current_device_logout', $this->request);
        
    }
}
