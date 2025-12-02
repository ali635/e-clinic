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
        Schema::table('areas', function (Blueprint $table) {
            // Drop existing foreign key
            $table->dropForeign(['city_id']);
            
            // Re-add with cascade delete
            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('areas', function (Blueprint $table) {
            // Drop cascade foreign key
            $table->dropForeign(['city_id']);
            
            // Re-add without cascade
            $table->foreign('city_id')
                ->references('id')
                ->on('cities');
        });
    }
};
