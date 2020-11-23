<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('aptId');
            $table->foreign('aptId')->references('id')->on('apartments')->onDelete('cascade');
            $table->longText('title');
            $table->longText('desc');
            $table->string('type');
            $table->string('object');
            $table->longText('upload_file')->nullable();
            $table->boolean('isDraft')->default('0');
            $table->boolean('isShowToProprietor')->default('0');
            $table->enum('status', ['approved', 'ongoing', 'pending', 'finish'])->default('pending');
            $table->unsignedBigInteger('star')->nullable();
            $table->boolean('isSelectMode')->default('0');
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
        Schema::dropIfExists('repairs');
    }
}
