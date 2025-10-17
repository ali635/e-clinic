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
            $table->string('hear_about_us')->nullable();
        });
    }

    public function down(): void {}
};
