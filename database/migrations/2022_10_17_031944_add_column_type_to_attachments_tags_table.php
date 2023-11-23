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
        Schema::table('attachments_tags', function (Blueprint $table) {
            $table->enum('tag_type',['attachment','asset'])->comment('Tag Type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attachments_tags', function (Blueprint $table) {
            $table->dropColumn('tag_type');
        });
    }
};
