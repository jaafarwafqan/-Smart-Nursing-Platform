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
        Schema::create('professor_researches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('title');
            $table->enum('research_type', ['qualitative', 'quantitative']);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('publication_status', ['draft', 'submitted', 'under_review', 'accepted', 'published', 'rejected']);
            $table->integer('completion_percentage')->default(0);
            $table->text('abstract')->nullable();
            $table->string('keywords')->nullable();
            $table->string('file_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_researches');
    }
};
