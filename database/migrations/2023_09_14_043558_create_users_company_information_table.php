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
        Schema::create('users_company_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('corporate_structure')->nullable();
            $table->string('corporate_trustee')->nullable();
            $table->string('trading_name')->nullable();
            $table->string('abn')->nullable();
            $table->string('acn')->nullable();
            $table->string('company_director')->nullable();
            $table->string('main_contact_person')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('about_us_description')->nullable();
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
        Schema::dropIfExists('users_company_information');
    }
};
