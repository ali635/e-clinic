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
        Schema::table('patients', function (Blueprint $table) {
            // Drop existing foreign keys
            $table->dropForeign(['country_id']);
            $table->dropForeign(['city_id']);
            $table->dropForeign(['area_id']);
            
            // Re-add with cascade delete
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade');
                
            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade');
                
            $table->foreign('area_id')
                ->references('id')
                ->on('areas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Drop cascade foreign keys
            $table->dropForeign(['country_id']);
            $table->dropForeign(['city_id']);
            $table->dropForeign(['area_id']);
            
            // Re-add without cascade
            $table->foreign('country_id')
                ->references('id')
                ->on('countries');
                
            $table->foreign('city_id')
                ->references('id')
                ->on('cities');
                
            $table->foreign('area_id')
                ->references('id')
                ->on('areas');
        });
    }
};
