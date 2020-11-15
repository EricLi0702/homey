<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('aptId');
            $table->foreign('aptId')->references('id')->on('apartments')->onDelete('cascade');
            $table->text('name');
            $table->text('equipment');
            $table->text('nb');
            $table->text('outline');
            $table->unsignedBigInteger('max');
            $table->text('upload_file')->nullable();
            $table->boolean('isUsing')->default('0');
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
        Schema::dropIfExists('facilities');
    }
}
