<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('fullname')->unique();;
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phoneNumber')->unique()->nullable();
            $table->string('specializtion')->nullable();
            $table->string('location')->nullable();
            $table->string('role');
            $table->string('genre')->nullable();
            $table->string('state')->nullable();
            $table->integer('treatmentDuration')->nullable();
            $table->time('closingTime')->nullable();
            $table->time('openningTime')->nullable();
            $table->time('breakendingtime')->nullable();
            $table->time('breakbeginningtime')->nullable();
            $table->string('medicalNumer')->nullable();
            $table->string('ProfilePhoto')->nullable();
            $table->string('certificateImage')->nullable();
            $table->integer('age')->nullable();
            $table->integer('points')->default(0);
            $table->timestamp('email_verified_at')->nullable();
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
};