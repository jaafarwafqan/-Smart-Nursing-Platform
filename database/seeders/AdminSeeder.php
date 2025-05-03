<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        /* 1️⃣ إنشاء أو استرجاع مدير النظام */
        $admin = User::firstOrCreate(
            ['email' => 'jaafar1@jaafar1.com'],
            [
                'name'     => 'مدير النظام',
                'password' => Hash::make('12345678'),
                'is_admin' => true,
                'type'     => 'admin',
                'branch_id'=> null,
            ]
        );

        /* 2️⃣ إنشاء دور الـadmin وإسناد جميع الصلاحيات إليه */
        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $role->syncPermissions(Permission::all());

        /* 3️⃣ ربط الدور بالمستخدم */
        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
