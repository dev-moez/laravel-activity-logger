<?php

namespace Moez\ActivityLogger\Http\Listeners;

use Illuminate\Http\Request;
use Moez\ActivityLogger\Services\AuthLogService;
use Illuminate\Auth\Events\OtherDeviceLogout;

class OtherDeviceLogoutListener
{
    /**
     * Create the event listener.
     */
    public function __construct(public readonly Request $request) {}

    /**
     * Handle the event.
     */
    public function handle(OtherDeviceLogout $event): void
    {
        if (!config('user-activity-log.events.auth.other_device_logout', false)) return;
        
        (new AuthLogService())->log('other_device_logout', $this->request);
        
    }
}
