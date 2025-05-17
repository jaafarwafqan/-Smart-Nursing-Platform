<?php

namespace App\Traits;

trait HasUserType
{
    public function isAdmin(): bool
    {
        return $this->type === 'admin';
    }

    public function isSupervisor(): bool
    {
        return $this->type === 'supervisor';
    }

    public function isUser(): bool
    {
        return $this->type === 'user';
    }

    public function isAdminOrSupervisor(): bool
    {
        return $this->isAdmin() || $this->isSupervisor();
    }

    public function canAccessDashboard(): bool
    {
        return $this->isAdminOrSupervisor();
    }
} 