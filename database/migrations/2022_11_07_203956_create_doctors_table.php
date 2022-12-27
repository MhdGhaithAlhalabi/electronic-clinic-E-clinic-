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
            $table->foreignId('region_id');
            $table->integer('num-consulting')->nullable();
            $table->integer('num-likes')->nullable();
            $table->integer('num-views')->nullable();
            $table->boolean('sex');
            $table->string('image');
            $table->foreignId('specialization_id');
            $table->integer('rate');
            $table->string('main_title');
            $table->string('title');
            $table->string('certificate_image');
            $table->string('opening_time');
            $table->string('full_address');
            $table->boolean('status')->nullable();
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
