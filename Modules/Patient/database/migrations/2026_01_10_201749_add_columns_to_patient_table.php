<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Drop the existing unique index
            $table->dropUnique(['email']);
            
            // Modify the column to be nullable
            $table->string('email')->nullable()->change();
            
            // Re-add the unique index
            $table->unique('email');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Drop the unique index
            $table->dropUnique(['email']);
            
            // Revert column to non-nullable
            $table->string('email')->nullable(false)->change();
            
            // Re-add the unique index
            $table->unique('email');
        });
    }
};