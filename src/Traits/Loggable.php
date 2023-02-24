<?php
namespace Moez\ActivityLogger\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Moez\ActivityLogger\Services\LogService;
use Moez\ActivityLogger\Services\ModelLogService;

trait Loggable
{
    public static function bootLoggable()
    {
        if (config('user-activity-log.events.model.creating', false)) {
            self::creating(function ($model) {
                self::log($model, 'creating');
            });
        }
        
        if (config('user-activity-log.events.model.created', false)) {
            self::created(function ($model) {
                self::log($model, 'created');
            });
        }
        
        if (config('user-activity-log.events.model.updating', false)) {
            self::updating(function ($model) {
                self::log($model, 'updating');
            });
        }
        
        if (config('user-activity-log.events.model.updated', false)) {
            self::updated(function ($model) {
                self::log($model, 'updated');
            });
        }
        
        if (config('user-activity-log.events.model.deleting', false)) {
            self::deleting(function ($model) {
                self::log($model, 'deleting');
            });
        }
        
        if (config('user-activity-log.events.model.deleted', false)) {
            self::deleted(function ($model) {
                self::log($model, 'deleted');
            });
        }
        
        if (config('user-activity-log.events.model.force_deleted', false)) {
            if (in_array(SoftDeletes::class ,class_uses(self::class))) 
            {
                self::forceDeleted(function ($model) {
                    self::log($model, 'force_deleted');
                });
            }
        }
        
        if (config('user-activity-log.events.model.restored', false)) {
            if (in_array(SoftDeletes::class ,class_uses(self::class)))
            {
                self::restored(function ($model) {
                    self::log($model, 'restored');
                });
            }
        }
        
        if (config('user-activity-log.events.model.retrieved', false)) {
            self::retrieved(function ($model) {
                self::log($model, 'retrieved');
            });
        }
    }

    public static function log($model, $modelEventType)
    {
        // If no user has been set or preventLogging is set to true of the general configuration is set to false
        if ($model->preventLogging || !config('user-activity-log.model_log_enabled')) return;
        
        // If $ignoreLogEvents property is set in the model, then verify $modelEventType existence in the $ignoreLogEvents
        if (!empty($model->ignoreLogEvents))
        {
            if (in_array($modelEventType, $model->ignoreLogEvents)) return;
        }
        
        // If $logEvents property is set in the model, then verify $modelEventType existence in the $logEvents
        if (!empty($model->logEvents))
        {
            if (!in_array($modelEventType, $model->logEvents)) return;
        }
        
        $service = new ModelLogService();
        $service->create($model, $modelEventType, request());   
    }
}