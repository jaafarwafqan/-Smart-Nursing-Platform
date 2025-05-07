<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->boolean('is_scopus_indexed')->default(false)->after('type');
            $table->boolean('is_clarivate_indexed')->default(false)->after('is_scopus_indexed');
        });
    }

    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn(['is_scopus_indexed', 'is_clarivate_indexed']);
        });
    }
}; 