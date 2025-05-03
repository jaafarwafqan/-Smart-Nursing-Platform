<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    /** إنشاء مستخدم جديد */
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {

            $roles = Arr::pull($data, 'roles', []);        // [', 'employee', …]

            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            /* ربط الأدوار */
            if ($roles) {
                $roleModels = Role::whereIn('name', $roles)->get();
                $user->syncRoles($roleModels);
            }

            return $user;
        });
    }

    /** تحديث بيانات مستخدم */
    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {

            $roles = Arr::pull($data, 'roles', null);

            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);   // لا تغيّر كلمة المرور إذا كانت فارغة
            }

            $user->update($data);

            if ($roles !== null) {
                $roleModels = Role::whereIn('name', $roles)->get();
                $user->syncRoles($roleModels);
            }

            return $user;
        });
    }

    /** حذف مستخدم */
    public function delete(User $user): void
    {
        // حماية الأدمن الرئيسي يمكن وضع منطق إضافي هنا إن أردت
        $user->delete();
    }
}
