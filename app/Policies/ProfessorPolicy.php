<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Professor;

class ProfessorPolicy
{
    public function viewAny(User $user): bool    { return $user->can('manage_professors'); }
    public function view(User $user, Professor $p): bool   { return $this->viewAny($user); }
    public function create(User $user): bool     { return $this->viewAny($user); }
    public function update(User $user, Professor $p): bool { return $this->viewAny($user); }
    public function delete(User $user, Professor $p): bool { return $this->viewAny($user); }
} 