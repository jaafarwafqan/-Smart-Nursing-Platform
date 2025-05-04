<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('student_researches', function (Blueprint $table) {
            $table->id();

            // الطالب
            $table->foreignId('student_id')
                ->constrained()              // => students.id
                ->cascadeOnDelete();

            // البحث
            $table->foreignId('research_id')   // ✔️ اسم مفرد
            ->constrained('researches')  // => researches.id
            ->cascadeOnDelete();

            // المشرف (اختياري مستقبلاً)
            // $table->foreignId('supervisor_id')
            //       ->nullable()
            //       ->constrained('professors')
            //       ->nullOnDelete();

            $table->enum('study_type', ['أولية', 'ماجستير', 'دكتوراه']);
            $table->string('status')->default('مقترح');
            $table->timestamps();


    });
    }
    public function down()
    {
        Schema::dropIfExists('student_researches');
    }
};
