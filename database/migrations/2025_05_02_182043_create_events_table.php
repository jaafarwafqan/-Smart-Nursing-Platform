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
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('branch_id')->nullable()->index();
            $table->string('event_type', 120);
            $table->string('event_title');
            $table->dateTime('event_datetime');
            $table->string('location');
            $table->string('lecturers')->nullable();
            $table->unsignedInteger('attendance')->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->text('description')->nullable();
            $table->boolean('planned')->nullable()->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
