<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentOfCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_of_communities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('coId');
            $table->foreign('coId')->references('id')->on('communities')->onDelete('cascade');
            $table->unsignedBigInteger('parentId')->nullable();
            $table->longText('content');
            $table->unsignedBigInteger('seq')->default('0');
            $table->unsignedBigInteger('lvl')->default('0');
            $table->boolean('isRemoved')->default('0');
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
        Schema::dropIfExists('comment_of_communities');
    }
}
