<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('professor_researches', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('research_type'); // qualitative, quantitative
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('publication_status'); // draft, submitted, under_review, accepted, published
            $table->integer('completion_percentage')->default(0);
            $table->text('abstract')->nullable();
            $table->string('keywords')->nullable();
            $table->string('file_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // جدول العلاقة بين البحوث والأساتذة
        Schema::create('professor_research_professor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_research_id')->constrained()->onDelete('cascade');
            $table->foreignId('professor_id')->constrained()->onDelete('cascade');
            $table->string('role'); // supervisor, reviewer
            $table->timestamps();
        });

        // جدول العلاقة بين البحوث والمجلات
        Schema::create('professor_research_journal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_research_id')->constrained()->onDelete('cascade');
            $table->foreignId('journal_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professor_research_journal');
        Schema::dropIfExists('professor_research_professor');
        Schema::dropIfExists('professor_researches');
    }
}; 