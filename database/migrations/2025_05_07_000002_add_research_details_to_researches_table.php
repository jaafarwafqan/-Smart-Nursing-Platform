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
        Schema::table('researches', function (Blueprint $table) {
            // First modify the existing research_type column
            $table->dropColumn('research_type');
            $table->enum('research_type', ['qualitative', 'quantitative'])->nullable()->after('research_title');
            
            // Then add the new columns
            $table->enum('publication_status', ['draft', 'submitted', 'under_review', 'accepted', 'published'])->nullable()->after('status');
            $table->integer('completion_percentage')->default(0)->after('publication_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('researches', function (Blueprint $table) {
            $table->dropColumn(['publication_status', 'completion_percentage']);
            $table->dropColumn('research_type');
            $table->string('research_type', 120)->nullable()->after('research_title');
        });
    }
}; 