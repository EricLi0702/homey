<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponseRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('response_repairs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('managerId')->nullable();
            $table->foreign('managerId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('repairId')->nullable();
            $table->foreign('repairId')->references('id')->on('repairs')->onDelete('cascade');
            $table->unsignedBigInteger('userId')->nullable();
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->longText('replyToClient')->nullable();
            $table->longText('replyFromClient')->nullable();
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
        Schema::dropIfExists('response_repairs');
    }
}
