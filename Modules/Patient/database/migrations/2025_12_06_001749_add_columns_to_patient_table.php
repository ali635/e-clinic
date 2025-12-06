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
            $table->foreignId('referral_id')->nullable()->constrained('referrals')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['referral_id']);
            $table->dropIndex(['referral_id']);
        });
    }
};
