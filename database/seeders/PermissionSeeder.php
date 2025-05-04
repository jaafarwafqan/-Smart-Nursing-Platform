<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'admin'     => ['manage_users','manage_events','manage_campaigns','manage_researches'],
            'professor' => ['manage_researches'],
            'employee'  => ['manage_events','manage_campaigns'],
            'student'   => [],
        ];

        foreach ($map as $role => $perms) {
            $r = Role::firstOrCreate(['name'=>$role,'guard_name'=>'web']);

            foreach ($perms as $p) {
                $perm = Permission::firstOrCreate(['name'=>$p,'guard_name'=>'web']);
            }

            // اربط الصلاحيات بالدور
            $r->syncPermissions($perms);   // <‑‑ المهم!
        }
    }
}
