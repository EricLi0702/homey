<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phoneNumber')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('ho')->nullable();
            $table->unsignedBigInteger('roleId')->nullable();
            $table->foreign('roleId')->references('id')->on('user_roles')->onDelete('cascade');
            $table->unsignedBigInteger('aptId')->nullable();
            $table->foreign('aptId')->references('id')->on('apartments')->onDelete('cascade');
            $table->unsignedBigInteger('buildingId')->nullable();
            $table->foreign('buildingId')->references('id')->on('buildings')->onDelete('cascade');
            $table->unsignedBigInteger('vercode')->default('0');
            $table->string('user_avatar')->default('/');
            $table->longText('newPush')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
