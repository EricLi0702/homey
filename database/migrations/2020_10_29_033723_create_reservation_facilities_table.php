<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_facilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('facilityId');
            $table->foreign('facilityId')->references('id')->on('facilities')->onDelete('cascade');
            $table->unsignedBigInteger('aptId');
            $table->foreign('aptId')->references('id')->on('apartments')->onDelete('cascade');
            $table->longText('title');
            $table->longText('purpose');
            $table->unsignedBigInteger('max');
            $table->timestamp('periodFrom')->nullable();
            $table->timestamp('periodTo')->nullable();
            $table->enum('status', ['allow', 'deny', 'pending'])->default('pending');
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
        Schema::dropIfExists('reservation_facilities');
    }
}
