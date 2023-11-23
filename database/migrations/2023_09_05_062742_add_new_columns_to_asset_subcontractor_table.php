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
        Schema::table('assets_subcontractor', function (Blueprint $table) {
            $table->string('charge_type')->nullable();
            $table->string('charge_unit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets_subcontractor', function (Blueprint $table) {
            $table->dropColumn('charge_type');
            $table->dropColumn('charge_unit');
        });
    }
};
