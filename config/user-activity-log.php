<?php

return [
    /**
     * Enable/disable model logging activities
     */

     'model_log_enabled' => env('USER_ACTIVITY_LOG_MODEL_ENABLED', true),
    
     /**
     * Enable/disable http logging
     */

     'http_log_enabled' => env('USER_ACTIVITY_LOG_HTTP_ENABLED', true),

     /**
      * The database connection you want to use
      */
    'connection' => config('database.default'),

    /**
      * The database connection which holds all authentication guards like users,admins ..etc
      */
    'authenticatable-connections' => config('database.default'),

    /**
     * Number of days of which model logs will be automatically deleted
     */
    'delete_model_logs_after' => 7, // Delete after 7 days by default, , set to 0 if you don't want to delete
    
    /**
     * Number of days of which model logs will be automatically deleted
     */
    'delete_http_logs_after' => 7, // Delete after 7 days by default, set to 0 if you don't want to delete

    /**
     * Model events to log
     * 
     * By default all basic 8 events of model
     */
    'events' => [
      'model' => [
        'creating' => false,
        'created' => true,
        'updating' => false,
        'updated' => true,
        'deleting' => false,
        'deleted' => true,
        'force_deleted' => true,
        'restored' => true,
        'retrieved' => false,
      ],
      'auth' => [
        'login' => true,
        'register' => true,
        'lockout' => true,
        'logout' => true,
        'forget_password' => true,
        'password_reset' => true,
        'changed_password' => true,
        'failed' => true,
        'attempting' => true,
      ]
    ]
    
];