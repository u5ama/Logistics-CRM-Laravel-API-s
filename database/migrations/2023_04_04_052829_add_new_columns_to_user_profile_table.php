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
        Schema::table('user_profile', function (Blueprint $table) {
            $table->string('account_terms')->after('address')->nullable();
            $table->string('credit_limit')->after('account_terms')->nullable();
            $table->enum('credit_activity',['yes','no'])->comment('Credit Check')->default('yes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profile', function (Blueprint $table) {
            $table->dropColumn('account_terms');
            $table->dropColumn('credit_limit');
            $table->dropColumn('credit_activity');
        });
    }
};
