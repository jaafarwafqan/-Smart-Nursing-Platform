<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Campaign;

class CampaignPolicy
{
    public function viewAny(User $u): bool           { return $u->can('manage_campaigns'); }
    public function view(User $u, Campaign $c): bool { return $this->viewAny($u); }
    public function create(User $u): bool           { return $this->viewAny($u); }
    public function update(User $u, Campaign $c): bool { return $this->viewAny($u); }
    public function delete(User $u, Campaign $c): bool { return $this->viewAny($u); }
}
