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
        Schema::table('related_service_visits', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['visit_id']);
            $table->dropForeign(['related_service_id']);
            
            // Re-add with cascade delete
            $table->foreign('visit_id')
                ->references('id')
                ->on('visits')
                ->onDelete('cascade');
                
            $table->foreign('related_service_id')
                ->references('id')
                ->on('related_services')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('related_service_visits', function (Blueprint $table) {
            // Drop cascade foreign keys
            $table->dropForeign(['visit_id']);
            $table->dropForeign(['related_service_id']);
            
            // Re-add without cascade
            $table->foreign('visit_id')
                ->references('id')
                ->on('visits');
                
            $table->foreign('related_service_id')
                ->references('id')
                ->on('related_services');
        });
    }
};
