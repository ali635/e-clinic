<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')
                ->unique()
                ->constrained('patients', 'id')
                ->onDelete('cascade');
            $table->string('fcm_token')->nullable();
            $table->string('current_lang')->nullable();
            $table->json('device_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_info');
    }
};
