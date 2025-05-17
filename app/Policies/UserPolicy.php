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
        return $user->hasPermissionTo('view_users');
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasPermissionTo('view_users');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_users');
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasPermissionTo('edit_users');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasPermissionTo('delete_users');
    }

    public function restore(User $user, User $model): bool
    {
        return $user->hasPermissionTo('manage_users');
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->hasPermissionTo('manage_users');
    }
}

