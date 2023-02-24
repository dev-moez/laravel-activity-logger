<?php

namespace Moez\ActivityLogger\Models;

use Moez\ActivityLogger\Models\HttpLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Moez\ActivityLogger\Models\Concerns\HasAuth;
use Moez\ActivityLogger\Models\Concerns\HasHttpLog;

class AuthLog extends Model
{
    use HasAuth;
    use HasHttpLog;
    
    public $timestamps = false;
    
    protected $fillable = [
        'authenticatable_id',
        'authenticatable_type',
        'event_type',
        'data',
        'created_at',
        'request_hash'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'data' => 'json'
    ];

    public function __construct()
    {
        $this->setConnection(config("user-activity-log.connection"));
    }
    
}
