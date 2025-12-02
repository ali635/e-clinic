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
        Schema::table('patient_diseases', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['disease_id']);
            
            // Re-add with cascade delete
            $table->foreign('patient_id')
                ->references('id')
                ->on('patients')
                ->onDelete('cascade');
                
            $table->foreign('disease_id')
                ->references('id')
                ->on('diseases')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_diseases', function (Blueprint $table) {
            // Drop cascade foreign keys
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['disease_id']);
            
            // Re-add without cascade
            $table->foreign('patient_id')
                ->references('id')
                ->on('patients');
                
            $table->foreign('disease_id')
                ->references('id')
                ->on('diseases');
        });
    }
};
