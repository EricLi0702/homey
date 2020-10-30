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
            $table->unsignedBigInteger('managerId');
            $table->foreign('managerId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('repairId');
            $table->foreign('repairId')->references('id')->on('repairs')->onDelete('cascade');
            $table->text('replyToClient');
            $table->text('replyFromClient');
            $table->unsignedBigInteger('star');
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
