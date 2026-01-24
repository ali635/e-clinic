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
        Schema::create('visit_waitings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->nullable()->constrained('patients', 'id')->onDelete('cascade');
            $table->foreignId('visit_id')->nullable()->constrained('visits', 'id')->onDelete('cascade');
            $table->foreignId('room_id')->nullable()->constrained('rooms', 'id')->onDelete('cascade');
            $table->boolean('is_arrival')->default(0);
            $table->enum('status', ['pending', 'complete', 'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_waitings');
    }
};
