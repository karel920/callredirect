<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('team_id');
            $table->string('device_uuid')->unique();
            $table->string('nickname')->nullable();
            $table->string('model')->nullable();
            $table->string('phone')->nullable();
            $table->string('service')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('signal_status')->default(0);
            $table->string('app_version')->nullable();
            $table->boolean('is_enable')->default(true);
            $table->boolean('enable_call_record')->default(false);
            $table->boolean('enable_video_record')->default(false);
            $table->boolean('is_logging')->default(false);
            $table->string('android_version')->nullable();
            $table->integer('battery_status')->default(0);
            $table->integer('setting_status')->default(0);
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
}
