<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('professor_research', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained('professors')->onDelete('cascade');
            $table->foreignId('research_id')->constrained('researches')->onDelete('cascade');
            $table->string('role')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('professor_research');
    }
}; 