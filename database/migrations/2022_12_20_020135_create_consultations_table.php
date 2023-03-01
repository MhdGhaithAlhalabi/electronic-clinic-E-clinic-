<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('details');
            $table->string('time');
            $table->string('type_complaint');
            $table->string('status_pain');
            $table->string('frequency');
            $table->string('severity_pain');
            $table->string('nature_complaint');
            $table->string('factors_increase_complaint');
            $table->string('factors_reduce_complaint');
            $table->string('place_pain');
            $table->longText('images')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('patient_id');
            $table->foreignId('doctor_id')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('specialization_id');
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
        Schema::dropIfExists('consultations');
    }
};
