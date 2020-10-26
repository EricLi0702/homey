<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->string('title');
            $table->json('type');
            $table->enum('status', ['before', 'ongoing', 'finish'])->default('ongoing');
            $table->string('period')->nullable();
            $table->timestamp('periodFrom')->nullable();
            $table->timestamp('periodTo')->nullable();
            $table->text('content')->nullable();
            $table->boolean('isDraft')->default('0');
            $table->boolean('isDowngrade')->default('0');
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
        Schema::dropIfExists('notifications');
    }
}
