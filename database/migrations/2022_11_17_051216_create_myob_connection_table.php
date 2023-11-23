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
        Schema::create('myob_connection', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token_type')->nullable();
            $table->string('expires_in')->nullable();
            $table->string('access_token',1000)->nullable();
            $table->string('refresh_token',1000)->nullable();
            $table->string('connection_status')->nullable();
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
        Schema::dropIfExists('myob_connection');
    }
};
