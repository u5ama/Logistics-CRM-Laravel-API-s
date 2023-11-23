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
        Schema::create('quotes_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('terms_conditions',5000)->nullable();
            $table->string('op_manager_name')->nullable();
            $table->string('op_manager_email')->nullable();
            $table->string('op_manager_phone')->nullable();
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
        Schema::dropIfExists('quotes_settings');
    }
};
