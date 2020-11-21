<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuggestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->longText('title');
            $table->longText('content');
            $table->longText('upload_file')->nullable();
            $table->json('view_cnt')->nullable();
            $table->json('heart_cnt')->nullable();
            $table->json('like_cnt')->nullable();
            $table->json('dislike_cnt')->nullable();
            $table->json('comment_cnt')->nullable();
            $table->boolean('isDraft')->default('0');
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
        Schema::dropIfExists('suggestions');
    }
}
