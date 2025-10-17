<?php

use Awcodes\Curator\Facades\Curator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->boolean('is_default')->default(false);
            $table->enum('dir', ['rtl', 'ltr'])->default('ltr');        
        });
    }

    public function down(): void {}
};
