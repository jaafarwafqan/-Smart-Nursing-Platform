<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['ذكر', 'أنثى']);
            $table->date('birthdate')->nullable();
            $table->string('university_number')->nullable();
            $table->enum('study_type', ['أولية', 'ماجستير', 'دكتوراه']);
            $table->unsignedTinyInteger('study_year')->nullable();
            $table->string('program')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
