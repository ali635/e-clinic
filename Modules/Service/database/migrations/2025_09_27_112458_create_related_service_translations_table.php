<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('related_service_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('related_service_id')->unsigned();
            $table->string('name');
            $table->string('locale');
            $table->unique(['related_service_id', 'locale']);
            $table->foreign('related_service_id')
                ->references('id')
                ->on('related_services')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('related_service_translations');
    }
};
