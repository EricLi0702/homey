<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('aptId')->nullable();
            $table->foreign('aptId')->references('id')->on('apartments')->onDelete('cascade');
            $table->longText('title');
            $table->longText('content');
            $table->longText('upload_file')->nullable();
            $table->enum('status', ['before', 'ongoing', 'finish'])->default('ongoing');
            $table->string('period')->nullable();
            $table->timestamp('periodFrom')->nullable();
            $table->timestamp('periodTo')->nullable();
            $table->json('comment_cnt')->nullable();
            $table->json('view_cnt')->nullable();
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
        Schema::dropIfExists('communities');
    }
}
