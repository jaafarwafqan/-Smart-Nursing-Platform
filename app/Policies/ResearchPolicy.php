<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Research;

class ResearchPolicy
{
    public function viewAny(User $u): bool             { return $u->can('manage_researches'); }
    public function view(User $u, Research $r): bool   { return $this->viewAny($u); }
    public function create(User $u): bool             { return $this->viewAny($u); }
    public function update(User $u, Research $r): bool { return $this->viewAny($u); }
    public function delete(User $u, Research $r): bool { return $this->viewAny($u); }
}
