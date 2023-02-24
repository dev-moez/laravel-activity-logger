<?php

namespace Moez\ActivityLogger\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Moez\ActivityLogger\Models\HttpLog;



trait HasHttpLog
{
    /**
     * Get the httpLoh associated with the ModelLog
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function httpLog(): HasOne
    {
        return $this->hasOne(HttpLog::class, 'http_log_id', 'id');
    }
    
}
