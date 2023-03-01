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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('mobile_number')->unique();
            $table->string('clinic_number')->unique();
            $table->foreignId('city_id');
            $table->integer('num_consulting')->nullable();
            $table->integer('num_post')->nullable();
            $table->boolean('sex');
            $table->string('image');
            $table->foreignId('specialization_id');
            $table->integer('rate')->nullable();
            $table->string('main_title');
            $table->string('title');
            $table->string('certificate_image');
            $table->string('certificate_number');
            $table->string('opening_time');
            $table->string('full_address');
            $table->text('fireBaseToken')->nullable();
            $table->boolean('status')->nullable();
            $table->float('lon');
            $table->float('lat');
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
        Schema::dropIfExists('doctors');
    }
};
