<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /* يُعطي الـadmin جميع الصلاحيات قبل فحص أي Ability أخرى */
    public function before(User $user, string $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /** مشاهدة قائمة المستخدمين */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_users');
    }

    /** مشاهدة مستخدم واحد */
    public function view(User $user, User $model): bool
    {
        return $this->viewAny($user);
    }

    /** إنشاء مستخدم */
    /** صلاحية إنشاء مستخدم */
    public function create(User $user): bool
    {
        // ثلاث طرق تفي بالغرض (اختر واحدة)
        return
            $user->hasRole('admin') ||           // الدور Admin
            $user->can('manage_users');          // أو صلاحية Spatie
        // $user->can('create_users');       // إذا أضفت permission خاص
    }

    /** تعديل مستخدم */
    public function update(User $user, User $model): bool
    {
        return
            $this->viewAny($user) &&             // صلاحية عرض المستخدمين
            !$model->hasRole('admin') &&          // ليس Admin
            $user->id !== $model->id;            // ليس نفسه
        // أو

    }

    /** حذف مستخدم */
    public function delete(User $user, User $model): bool
    {
        // منع حذف مستخدم يملك دور admin أو حذف النفس
        if ($model->hasRole('admin') || $user->id === $model->id) {
            return false;
        }

        return $this->viewAny($user);
    }
}
