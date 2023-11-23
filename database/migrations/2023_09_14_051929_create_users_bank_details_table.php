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
        Schema::create('users_bank_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('bsb')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->string('banking_corporation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *o'
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_bank_details');
    }
};
