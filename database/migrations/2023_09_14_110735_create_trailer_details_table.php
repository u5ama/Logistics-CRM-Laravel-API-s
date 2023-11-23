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
        Schema::create('trailer_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('year')->nullable();
            $table->string('body_type')->nullable();
            $table->string('capacity')->nullable();
            $table->string('tare_gross')->nullable();
            $table->string('suspension')->nullable();
            $table->string('trailer_checks',500)->nullable();
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
        Schema::dropIfExists('trailer_details');
    }
};
