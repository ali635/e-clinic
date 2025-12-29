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
        Schema::create('visit_follows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->nullable()->constrained('patients', 'id')->onDelete('cascade');
            $table->foreignId('visit_id')->nullable()->constrained('visits', 'id')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->enum('status', ['answer', 'not_answer'])->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_follows');
    }
};
