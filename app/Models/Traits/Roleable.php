<?php


namespace App\Models\Traits;

use App\Models\Role;

trait Roleable
{
    public function hasRole(int $roleId): bool
    {
        return $this->roles->filter(fn (Role $role) => $role->id === $roleId)->isNotEmpty();
    }
}
