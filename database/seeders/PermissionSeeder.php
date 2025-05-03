<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * خريطة <الدور => [الصلاحيات]>
         * أضِف أو عدِّل حسب حاجتك.
         */
        $rolePermissions = [
            'admin'     => ['manage_users', 'manage_events', 'manage_campaigns', 'manage_researches'],
            'professor' => ['manage_researches'],
            'student'   => [],
            'employee'  => ['manage_events', 'manage_campaigns'],
        ];

        /* 1️⃣  إنشاء الصلاحيات (إن لم تكن موجودة) */
        $allPermissions = collect($rolePermissions)->flatten()->unique();

        foreach ($allPermissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm, 'guard_name' => 'web']
            );
        }

        /* 2️⃣  إنشاء الأدوار وإسناد صلاحياتها */
        foreach ($rolePermissions as $role => $perms) {

            /** @var Role $roleModel */
            $roleModel = Role::firstOrCreate(
                ['name' => $role, 'guard_name' => 'web']
            );

            // جلب نماذج الصلاحيات المطابقة وتعيينها
            $permissionModels = Permission::whereIn('name', $perms)->get();
            $roleModel->syncPermissions($permissionModels);
        }

        $this->command->info('Roles & permissions seeded successfully.');
    }
}
