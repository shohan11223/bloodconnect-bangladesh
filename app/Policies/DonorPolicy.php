<?php

namespace App\Policies;

use App\Models\Donor;
use App\Models\User;

class DonorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->isModerator();
    }

    public function view(User $user, Donor $donor): bool
    {
        return $user->isSuperAdmin() || 
               $user->isModerator() || 
               $user->id === $donor->user_id;
    }

    public function create(User $user): bool
    {
        return !$user->isSuperAdmin();
    }

    public function update(User $user, Donor $donor): bool
    {
        return $user->isSuperAdmin() || $user->id === $donor->user_id;
    }

    public function delete(User $user, Donor $donor): bool
    {
        return $user->isSuperAdmin() || $user->id === $donor->user_id;
    }

    public function approve(User $user, Donor $donor): bool
    {
        return $user->isSuperAdmin() || $user->isModerator();
    }
}