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
        Schema::table('users_operators_records', function (Blueprint $table) {
            $table->string('opt_other_card')->nullable();
            $table->string('opt_other_card_number')->nullable();
            $table->string('opt_other_card_issue_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_operators_records', function (Blueprint $table) {
            $table->dropColumn('opt_other_card');
            $table->dropColumn('opt_other_card_number');
            $table->dropColumn('opt_other_card_issue_date');
        });
    }
};
