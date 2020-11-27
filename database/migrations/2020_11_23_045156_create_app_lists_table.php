<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_lists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('device_id');
            $table->string('package');
            $table->string('version');
            $table->timestamp('installed_at')->nullable();
            $table->timestamp('upgraded_at')->nullable();
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
        Schema::dropIfExists('app_lists');
    }
}
