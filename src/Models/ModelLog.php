<?php

namespace Moez\ActivityLogger\Models;

use Moez\ActivityLogger\Models\HttpLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Moez\ActivityLogger\Models\Concerns\HasAuth;
use Moez\ActivityLogger\Models\Concerns\HasHttpLog;

class ModelLog extends Model
{
    use HasAuth;
    use HasHttpLog;
    
    public $timestamps = false;
    
    protected $fillable = [
        'authenticatable_id',
        'authenticatable_type',
        'model_type',
        'model_id',
        'table_name',
        'event_type',
        'data',
        'created_at',
        'request_hash',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'data' => 'json'
    ];

    public function __construct()
    {
        $this->setConnection(config("user-activity-log.connection"));
    }

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
