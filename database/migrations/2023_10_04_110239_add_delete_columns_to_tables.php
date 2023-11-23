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
        Schema::table('users_company_information', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users_company_addresses', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users_checklist_files', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users_bank_details', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users_insurances', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users_operators_records', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users_company_compliance_checklist', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('trucks_details', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('trailer_details', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('plant_details', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users_company_requirement_checklist', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users_company_equipment_checklist', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('users_company_hire_checklist', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
