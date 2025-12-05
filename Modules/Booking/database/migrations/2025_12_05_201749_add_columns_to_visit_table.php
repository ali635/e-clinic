<?php

use Awcodes\Curator\Facades\Curator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->longText('chief_complaint')->nullable();
            $table->longText('medical_history')->nullable();
            $table->longText('diagnosis')->nullable();
            $table->string('sys')->nullable();
            $table->string('dia')->nullable();
            $table->string('pulse_rate')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('body_max_index')->nullable();

        });
    }

    public function down(): void {}
};
