<?php

namespace App\Policies;

use App\Models\Hospital;
use App\Models\User;

class HospitalPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Hospital $hospital): bool
    {
        return $hospital->isApproved() || 
               $user->isSuperAdmin() || 
               $user->isModerator() || 
               $user->id === $hospital->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Hospital $hospital): bool
    {
        return $user->isSuperAdmin() || $user->id === $hospital->user_id;
    }

    public function delete(User $user, Hospital $hospital): bool
    {
        return $user->isSuperAdmin();
    }

    public function approve(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isModerator();
    }
}