<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Student;

class StudentPolicy
{
    public function viewAny(User $user): bool    { return $user->can('manage_students'); }
    public function view(User $user, Student $s): bool   { return $this->viewAny($user); }
    public function create(User $user): bool     { return $this->viewAny($user); }
    public function update(User $user, Student $s): bool { return $this->viewAny($user); }
    public function delete(User $user, Student $s): bool { return $this->viewAny($user); }
} 