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
        Schema::create('users_company_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('business_number_street',500)->nullable();
            $table->string('business_suburb')->nullable();
            $table->string('business_state')->nullable();
            $table->string('business_post_code')->nullable();
            $table->string('postal_number_street')->nullable();
            $table->string('postal_suburb')->nullable();
            $table->string('postal_state')->nullable();
            $table->string('postal_post_code')->nullable();
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
        Schema::dropIfExists('users_company_addresses');
    }
};
