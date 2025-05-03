<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Grant all abilities to admin users before checking other abilities.
     */
    public function before(User $user, string $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }
    }

    /**
     * View any user.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('manage_users');
    }

    /**
     * View a specific user.
     */
    public function view(User $user, User $model): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Create a new user.
     */
    public function create(User $user): bool
    {
        return $user->can('manage_users');
    }

    /**
     * Update an existing user.
     */
    public function update(User $user, User $model): bool
    {
        return $this->viewAny($user) &&
            !$model->hasRole('admin') && // Prevent updating admin users
            $user->id !== $model->id;   // Prevent updating self
    }

    /**
     * Delete a user.
     */
    public function delete(User $user, User $model): bool
    {
        return $this->viewAny($user) &&
            !$model->hasRole('admin') && // Prevent deleting admin users
            $user->id !== $model->id;   // Prevent deleting self
    }
}
