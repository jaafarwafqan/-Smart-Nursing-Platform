<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProfessorResearch;

class ProfessorResearchPolicy
{
    public function viewAny(User $user): bool    { return $user->can('manage_professor_researches'); }
    public function view(User $user, ProfessorResearch $r): bool   { return $this->viewAny($user); }
    public function create(User $user): bool     { return $this->viewAny($user); }
    public function update(User $user, ProfessorResearch $r): bool { return $this->viewAny($user); }
    public function delete(User $user, ProfessorResearch $r): bool { return $this->viewAny($user); }
} 