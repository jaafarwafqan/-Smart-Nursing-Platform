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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name',   191);
            $table->string('email',  191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',191);

            // 🔹 نوع المستخدم: admin | supervisor | user
            $table->enum('type', ['admin', 'supervisor', 'user'])
                ->default('user')
                ->nullable();

            // 🔹 علاقة بالفرع
            $table->foreignId('branch_id')
                ->nullable()
                ->constrained('branches')
                ->nullOnDelete();

            // 🔹 هل هو أدمن عام؟
            $table->boolean('is_admin')->default(false);

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();           // إن كنت تستعمل الحذف الناعم
        });
    }

};
