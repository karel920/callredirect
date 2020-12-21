<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMsgLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msg_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('device_id');
            $table->text('content')->nullable();
            $table->integer('direction')->default(0);
            $table->string('part_phone');
            $table->timestamp('send_time')->nullable();
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
        Schema::dropIfExists('msg_logs');
    }
}
