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
        // Drop existing tables if they exist
        Schema::dropIfExists('research_journal');
        Schema::dropIfExists('journals');

        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['local', 'international', 'scopus', 'clarivate']);
            $table->string('publisher')->nullable();
            $table->string('issn')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('research_journal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('research_id')->references('id')->on('researches')->onDelete('cascade');
            $table->foreignId('journal_id')->references('id')->on('journals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_journal');
        Schema::dropIfExists('journals');
    }
}; 