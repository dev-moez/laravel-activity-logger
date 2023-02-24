<?php

namespace Moez\ActivityLogger\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class HttpLog extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'model_type',
        'model_id',
        'method',
        'uri',
        'body',
        'headers',
        'files',
        'ip_address',
        'user_agent',
        'is_mobile',
        'created_at',
        'request_hash',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'headers' => 'json',
        'is_mobile' => 'boolean'
    ];

    /**
     * Get the model that belongs to the Log
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model(): MorphTo
    {
        return $this->setConnection(config('user-activity-log.authenticatable-connections'))->morphTo();
    }
}
