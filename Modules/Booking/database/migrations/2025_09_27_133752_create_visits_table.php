<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->nullable()->constrained('patients', 'id');
            $table->foreignId('service_id')->nullable()->constrained('services', 'id');
            $table->string('price')->nullable();
            $table->boolean('is_arrival')->default(0);
            $table->dateTime('arrival_time')->nullable();
            $table->text('lab_tests')->nullable();
            $table->text('x-rays')->nullable();
            $table->text('treatment')->nullable();
            $table->text('doctor_description')->nullable();
            $table->text('secretary_description')->nullable();
            $table->string('total_price')->nullable();
            $table->text('notes')->nullable();
            $table->text('attachment')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
