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
        Schema::table('asset_documents', function (Blueprint $table) {
            $table->string('expiry')->nullable();
            $table->string('alert')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_documents', function (Blueprint $table) {
            $table->dropColumn('expiry');
            $table->dropColumn('alert');
        });
    }
};
