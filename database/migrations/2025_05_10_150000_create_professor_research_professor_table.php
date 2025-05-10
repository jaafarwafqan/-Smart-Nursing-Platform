<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('professor_research_professor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained('professors')->onDelete('cascade');
            $table->foreignId('professor_research_id')->constrained('professor_researches')->onDelete('cascade');
            $table->string('role')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('professor_research_professor');
    }
}; 