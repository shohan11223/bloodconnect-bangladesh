<?php

namespace App\Policies;

use App\Models\Ambulance;
use App\Models\User;

class AmbulancePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Ambulance $ambulance): bool
    {
        return $ambulance->isApproved() || 
               $user->isSuperAdmin() || 
               $user->isModerator() || 
               $user->id === $ambulance->user_id;
    }

    public function create(User $user): bool
    {
        return !$user->isSuperAdmin() && !$user->isModerator();
    }

    public function update(User $user, Ambulance $ambulance): bool
    {
        return $user->isSuperAdmin() || $user->id === $ambulance->user_id;
    }

    public function delete(User $user, Ambulance $ambulance): bool
    {
        return $user->isSuperAdmin() || $user->id === $ambulance->user_id;
    }

    public function approve(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isModerator();
    }
}