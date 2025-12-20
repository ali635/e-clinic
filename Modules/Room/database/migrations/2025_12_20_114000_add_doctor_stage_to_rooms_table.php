<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add the new doctor_stage column
        Schema::table('rooms', function (Blueprint $table) {
            $table->enum('doctor_stage', ['available', 'waiting_assistant', 'waiting_main'])
                ->default('available')
                ->after('current_visit_id');
        });

        // Migrate existing data: is_ready=true -> available, is_ready=false -> waiting_assistant
        DB::table('rooms')->update([
            'doctor_stage' => DB::raw("CASE WHEN is_ready = 1 THEN 'available' ELSE 'waiting_assistant' END")
        ]);

        // Drop the old is_ready column
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('is_ready');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back is_ready column
        Schema::table('rooms', function (Blueprint $table) {
            $table->boolean('is_ready')->default(true)->after('current_visit_id');
        });

        // Migrate data back: available -> true, others -> false
        DB::table('rooms')->update([
            'is_ready' => DB::raw("CASE WHEN doctor_stage = 'available' THEN 1 ELSE 0 END")
        ]);

        // Drop doctor_stage column
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn('doctor_stage');
        });
    }
};
