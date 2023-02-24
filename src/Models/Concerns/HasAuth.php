<?php

namespace Moez\ActivityLogger\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphTo;



trait HasAuth
{
    /**
     * Get the authenticatable that belongs to the Log
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function authenticatable(): MorphTo
    {
        return $this->setConnection(config('user-activity-log.authenticatable-connections'))->morphTo();
    }

    public function getAuthName(): string
    {
        return class_basename($this->authenticatable);
    }
    
}
