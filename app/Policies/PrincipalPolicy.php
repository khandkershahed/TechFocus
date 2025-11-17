<?php

namespace App\Policies;

use App\Models\Principal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PrincipalPolicy
{
    public function viewAny(User $user)
    {
        return true; // Handled by scope in controller
    }

    public function view(User $user, Principal $principal)
    {
        return $user->hasAccessTo($principal)
            ? Response::allow()
            : Response::deny('You do not have access to this principal.');
    }

    public function create(User $user)
    {
        return $user->hasAnyRole(['SuperAdmin', 'BrandAdmin', 'Contributor']);
    }

    public function update(User $user, Principal $principal)
    {
        if ($user->hasRole('SuperAdmin')) {
            return true;
        }

        if ($user->hasRole('Viewer')) {
            return false; // Viewers can only view
        }

        return $user->hasAccessTo($principal);
    }

    public function delete(User $user, Principal $principal)
    {
        return $user->hasRole('SuperAdmin') || $principal->creator_id === $user->id;
    }
}