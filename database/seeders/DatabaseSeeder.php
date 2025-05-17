<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            PermissionSeeder::class,
            BranchesTableSeeder::class,   // يملأ جدول الفروع
            AdminSeeder::class,           // ينشئ مدير النظام في النهاية
        ]);
    }
}
