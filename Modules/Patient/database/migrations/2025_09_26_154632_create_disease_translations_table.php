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
        Schema::create('disease_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('disease_id')->unsigned();
            $table->string('name');
            $table->string('locale');
            $table->unique(['disease_id', 'locale']);
            $table->foreign('disease_id')
                ->references('id')
                ->on('diseases')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disease_translations');
    }
};
