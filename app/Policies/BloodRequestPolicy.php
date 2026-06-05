<?php

namespace App\Policies;

use App\Models\BloodRequest;
use App\Models\User;

class BloodRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, BloodRequest $bloodRequest): bool
    {
        return $user->isSuperAdmin() || 
               $user->isModerator() || 
               $user->id === $bloodRequest->created_by;
    }

    public function create(User $user): bool
    {
        return $user->isReceiver() || $user->isSuperAdmin();
    }

    public function update(User $user, BloodRequest $bloodRequest): bool
    {
        return $user->isSuperAdmin() || $user->id === $bloodRequest->created_by;
    }

    public function delete(User $user, BloodRequest $bloodRequest): bool
    {
        return $user->isSuperAdmin() || $user->id === $bloodRequest->created_by;
    }

    public function accept(User $user, BloodRequest $bloodRequest): bool
    {
        return $user->isDonor() && $user->donor && $user->donor->isEligible();
    }
}