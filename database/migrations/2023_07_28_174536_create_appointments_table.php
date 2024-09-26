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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('users')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('appointmentDate');
            $table->dateTime('appointmentEndDate');
           // $table->time('appointmentTime');
           // $table->time('appointmentEndTime');
           // $table->String('periodTime');
           // $table->string('dayName');
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
        Schema::dropIfExists('appointments');
    }
};
