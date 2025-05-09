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
        Schema::create('professor_research_journal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_research_id')->constrained('professor_researches')->onDelete('cascade');
            $table->foreignId('journal_id')->constrained('journals')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_research_journal');
    }
};
