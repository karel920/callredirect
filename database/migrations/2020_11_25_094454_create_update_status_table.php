<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('update_status', function (Blueprint $table) {
            $table->id();
            $table->integer('device_id');
            $table->boolean('status_incoming')->default(true);
            $table->boolean('status_outgoing')->default(true);
            $table->boolean('status_blacklist')->default(true);            
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
        Schema::dropIfExists('update_status');
    }
}
