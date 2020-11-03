<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsRemovedToCommentOfSuggestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comment_of_suggestions', function (Blueprint $table) {
            $table->boolean('isRemoved')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comment_of_suggestions', function (Blueprint $table) {
            $table->dropColumn(['isRemoved']);
        });
    }
}
