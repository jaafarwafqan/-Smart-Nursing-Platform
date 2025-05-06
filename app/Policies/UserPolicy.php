<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * admin يحصل على جميع الصلاحيات تلقائياً.
     */
    public function before(User $user): bool|null
    {
        return $user->hasRole('admin') ? true : null;
    }

    /* ========== CRUD ========== */

    public function viewAny(User $user): bool
    {
        return $user->can('manage_users');
    }

    public function view(User $user, User $model): bool
    {
        return $user->can('manage_users');
    }

    public function create(User $user): bool
    {
        return $user->can('manage_users');
    }

    public function update(User $user, User $model): bool
    {
        // لا تسمح بتعديل مدير النظام الرئيسي فقط
        if ($model->email === 'jaafar1@jaafar1.com') {
            return false;
        }
        return $user->can('manage_users');
    }

    public function delete(User $user, User $model): bool
    {
        // لا تسمح للمستخدم بحذف نفسه أو حذف مدير النظام الرئيسي فقط
        if ($user->is($model) || $model->email === 'jaafar1@jaafar1.com') {
            return false;
        }
        return $user->can('manage_users');
    }
}
