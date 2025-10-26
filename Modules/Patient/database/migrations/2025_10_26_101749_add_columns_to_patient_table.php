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
            $table->string('other_phone')->nullable();
            $table->foreignId('area_id')->nullable()->constrained('areas', 'id');
        });
    }

    public function down(): void {}
};
