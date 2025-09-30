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
            $table->foreignId('country_id')->nullable()->constrained('countries', 'id');
            $table->foreignId('city_id')->nullable()->constrained('cities', 'id');
        });
    }

    public function down(): void {}
};
