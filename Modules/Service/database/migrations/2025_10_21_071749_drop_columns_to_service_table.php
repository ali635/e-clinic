<?php

use Awcodes\Curator\Facades\Curator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('start');;
            $table->dropColumn('end');;
        });
    }

    public function down(): void {}
};
