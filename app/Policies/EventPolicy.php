<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;

class EventPolicy
{
    public function viewAny(User $user): bool    { return $user->can('manage_events'); }
    public function view(User $user, Event $e): bool   { return $this->viewAny($user); }
    public function create(User $user): bool     { return $this->viewAny($user); }
    public function update(User $user, Event $e): bool { return $this->viewAny($user); }
    public function delete(User $user, Event $e): bool { return $this->viewAny($user); }
}
