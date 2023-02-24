<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $connection = config('user-activity-log.connection');
        
        Schema::connection($connection)->create('model_logs', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('authenticatable');
            $table->nullableMorphs('model');
            $table->string('table_name')->nullable();
            $table->string('event_type');
            $table->json('data')->nullable();
            $table->dateTime('created_at');
            $table->string('request_hash', 32);
        });
        
        Schema::connection($connection)->create('auth_logs', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('authenticatable');
            $table->string('event_type');
            $table->dateTime('created_at');
            $table->string('request_hash', 32);
        });
        
        if (config('user-activity-log.http_log_enabled'))
        {
            Schema::connection($connection)->create('http_logs', function (Blueprint $table) {
                $table->id();
                $table->nullableMorphs('model');
                $table->string('method');
                $table->text('uri');
                $table->longText('body');
                $table->json('headers');
                $table->longText('files')->nullable();
                $table->ipAddress('ip_address');
                $table->text('user_agent');
                $table->boolean('is_mobile')->nullable();
                $table->dateTime('created_at');
                $table->string('request_hash', 32);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $connection = config('user-activity-log.connection');
        
        Schema::connection($connection)->dropIfExists('http_logs');
        Schema::connection($connection)->dropIfExists('auth_logs');
        Schema::connection($connection)->dropIfExists('model_logs');
    }
};
