<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trucks_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('type')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('year')->nullable();
            $table->string('body_type')->nullable();
            $table->string('truck_reg')->nullable();
            $table->string('trailer_reg')->nullable();
            $table->string('capacity')->nullable();
            $table->string('tare_gross')->nullable();
            $table->string('suspension')->nullable();
            $table->string('style')->nullable();
            $table->string('truck_checks',500)->nullable();
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
        Schema::dropIfExists('trucks_details');
    }
};
