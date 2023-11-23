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
        Schema::table('email_settings', function (Blueprint $table) {
            $table->string('account_name')->nullable();
            $table->string('account_bsb')->nullable();
            $table->string('account_number')->nullable();
            $table->string('terms',5000)->nullable();
            $table->string('inquiry_email')->nullable();
            $table->string('note',5000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_settings', function (Blueprint $table) {
            $table->dropColumn('account_name');
            $table->dropColumn('account_bsb');
            $table->dropColumn('account_number');
            $table->dropColumn('terms');
            $table->dropColumn('inquiry_email');
            $table->dropColumn('note');
        });
    }
};
