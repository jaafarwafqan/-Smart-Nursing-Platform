<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Research;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResearchPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view_researches');
    }

    public function view(User $user, Research $research): bool
    {
        return $user->hasPermissionTo('view_researches');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create_researches');
    }

    public function update(User $user, Research $research): bool
    {
        return $user->hasPermissionTo('edit_researches');
    }

    public function delete(User $user, Research $research): bool
    {
        return $user->hasPermissionTo('delete_researches');
    }

    public function restore(User $user, Research $research): bool
    {
        return $user->hasPermissionTo('manage_researches');
    }

    public function forceDelete(User $user, Research $research): bool
    {
        return $user->hasPermissionTo('manage_researches');
    }
}
