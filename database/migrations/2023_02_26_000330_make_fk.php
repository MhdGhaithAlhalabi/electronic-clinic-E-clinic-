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
        //->onDelete('cascade')
        Schema::table('doctors', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('specialization_id')->references('id')->on('specializations');
        });
        Schema::table('patients', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('specialization_id')->references('id')->on('specializations');
        });
        Schema::table('replies', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('question_id')->references('id')->on('questions');
        });
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('consultation_id')->references('id')->on('consultations');
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('room_id')->references('id')->on('rooms');
        });
        Schema::table('consultations', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('doctor_id')->references('id')->on('doctors');
        });
        Schema::table('complaints', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('doctor_id')->references('id')->on('doctors');
        });
        Schema::table('personals', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('patients');
        });
        Schema::table('medicals', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('patients');
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('specialization_id')->references('id')->on('specializations');
        });
        Schema::table('medications', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->foreign('consultation_id')->references('id')->on('consultations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
