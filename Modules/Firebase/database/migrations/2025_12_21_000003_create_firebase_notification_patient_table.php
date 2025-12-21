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
        Schema::create('firebase_notification_patient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('firebase_notification_id')
                ->constrained('firebase_notifications', 'id')
                ->onDelete('cascade');
            $table->foreignId('patient_id')
                ->constrained('patients', 'id')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firebase_notification_patient');
    }
};
