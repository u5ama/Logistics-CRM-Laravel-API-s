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
        Schema::create('users_operators_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('given_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('mobile')->nullable();
            $table->string('ohs_induction_card')->nullable();
            $table->string('ohs_induction_issuer')->nullable();
            $table->string('driver_license_number')->nullable();
            $table->string('driver_license_expiry')->nullable();
            $table->string('operator_license_type')->nullable();
            $table->string('operator_license_expiry')->nullable();
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
        Schema::dropIfExists('users_operators_records');
    }
};
