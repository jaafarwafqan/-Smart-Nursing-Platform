<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Journal;

class JournalPolicy
{
    public function viewAny(User $user): bool    { return $user->can('manage_journals'); }
    public function view(User $user, Journal $j): bool   { return $this->viewAny($user); }
    public function create(User $user): bool     { return $this->viewAny($user); }
    public function update(User $user, Journal $j): bool { return $this->viewAny($user); }
    public function delete(User $user, Journal $j): bool { return $this->viewAny($user); }
} 