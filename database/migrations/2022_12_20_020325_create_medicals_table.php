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
        Schema::create('medicals', function (Blueprint $table) {
            $table->id();
            $table->string('practices');//عادات غير صحية
            $table->string('medicines');//ادوية دائمة
            $table->string('surgery');//عملية جراحية
            $table->boolean('hypertension');//ارتفاع ضغط الدم
            $table->boolean('diabetes');//مرض السكري
            $table->string('genetic_diseases');//امراض وراثية
            $table->string('vaccines');//لقاحات
            $table->string('sensitive');//تحسس
            $table->foreignId('patient_id');
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
        Schema::dropIfExists('medicals');
    }
};
