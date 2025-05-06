<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Teacher;

class TeacherPolicy
{
    public function viewAny(User $user): bool    { return $user->can('manage_teachers'); }
    public function view(User $user, Teacher $t): bool   { return $this->viewAny($user); }
    public function create(User $user): bool     { return $this->viewAny($user); }
    public function update(User $user, Teacher $t): bool { return $this->viewAny($user); }
    public function delete(User $user, Teacher $t): bool { return $this->viewAny($user); }
} 