<?php

use Awcodes\Curator\Facades\Curator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->foreignId('race_id')->nullable()->constrained('patient_races')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['race_id']);
            $table->dropIndex(['race_id']);
        });
    }
};
