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
        Schema::create('users_insurances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();

            $table->string('work_policy_number')->nullable();
            $table->string('work_policy_expiry_date')->nullable();
            $table->string('work_cover_file')->nullable();

            $table->string('public_policy_number')->nullable();
            $table->string('public_policy_expiry_date')->nullable();
            $table->string('public_policy_file')->nullable();

            $table->string('equipment_policy_number')->nullable();
            $table->string('equipment_policy_expiry_date')->nullable();
            $table->string('equipment_policy_file')->nullable();
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
        Schema::dropIfExists('users_insurances');
    }
};
