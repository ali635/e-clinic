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
        Schema::table('feedback', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['visit_id']);
            $table->dropForeign(['patient_id']);
            
            // Re-add with cascade delete
            $table->foreign('visit_id')
                ->references('id')
                ->on('visits')
                ->onDelete('cascade');
                
            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            // Drop cascade foreign keys
            $table->dropForeign(['visit_id']);
            $table->dropForeign(['patient_id']);
            
            // Re-add without cascade
            $table->foreign('visit_id')
                ->references('id')
                ->on('visits');
                
            $table->foreign('patient_id')
                ->references('id')
                ->on('patients');
        });
    }
};
