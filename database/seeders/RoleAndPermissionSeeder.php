<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // إعادة تعيين الأدوار والصلاحيات المخزنة مؤقتاً
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // إنشاء الصلاحيات
        $permissions = [
            // إدارة المستخدمين
            'manage_users',
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',

            // إدارة الأبحاث
            'manage_researches',
            'view_researches',
            'create_researches',
            'edit_researches',
            'delete_researches',

            // إدارة الفعاليات
            'manage_events',
            'view_events',
            'create_events',
            'edit_events',
            'delete_events',

            // إدارة الحملات
            'manage_campaigns',
            'view_campaigns',
            'create_campaigns',
            'edit_campaigns',
            'delete_campaigns',

            // إدارة المجلات
            'manage_journals',
            'view_journals',
            'create_journals',
            'edit_journals',
            'delete_journals',

            // إدارة الطلاب
            'manage_students',
            'view_students',
            'create_students',
            'edit_students',
            'delete_students',

            // إدارة الأساتذة
            'manage_professors',
            'view_professors',
            'create_professors',
            'edit_professors',
            'delete_professors',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // إنشاء الأدوار
        $roles = [
            'super_admin' => 'مدير النظام',
            'admin' => 'مدير',
            'supervisor' => 'مشرف',
            'user' => 'مستخدم',
        ];

        foreach ($roles as $role => $description) {
            $role = Role::create(['name' => $role]);
            
            // تعيين جميع الصلاحيات للمدير الأعلى
            if ($role->name === 'super_admin') {
                $role->givePermissionTo(Permission::all());
            }
            
            // تعيين صلاحيات محددة للمدير
            if ($role->name === 'admin') {
                $role->givePermissionTo([
                    'manage_users',
                    'view_users',
                    'create_users',
                    'edit_users',
                    'manage_researches',
                    'view_researches',
                    'create_researches',
                    'edit_researches',
                    'manage_events',
                    'view_events',
                    'create_events',
                    'edit_events',
                    'manage_campaigns',
                    'view_campaigns',
                    'create_campaigns',
                    'edit_campaigns',
                    'manage_journals',
                    'view_journals',
                    'create_journals',
                    'edit_journals',
                    'manage_students',
                    'view_students',
                    'create_students',
                    'edit_students',
                    'manage_professors',
                    'view_professors',
                    'create_professors',
                    'edit_professors',
                ]);
            }
            
            // تعيين صلاحيات محددة للمشرف
            if ($role->name === 'supervisor') {
                $role->givePermissionTo([
                    'view_users',
                    'view_researches',
                    'create_researches',
                    'edit_researches',
                    'view_events',
                    'create_events',
                    'edit_events',
                    'view_campaigns',
                    'create_campaigns',
                    'edit_campaigns',
                    'view_journals',
                    'view_students',
                    'view_professors',
                ]);
            }
            
            // تعيين صلاحيات محددة للمستخدم العادي
            if ($role->name === 'user') {
                $role->givePermissionTo([
                    'view_researches',
                    'view_events',
                    'view_campaigns',
                    'view_journals',
                ]);
            }
        }
    }
} 