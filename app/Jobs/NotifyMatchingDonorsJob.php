<?php

namespace App\Jobs;

use App\Models\BloodRequest;
use App\Models\Donor;
use App\Notifications\BloodRequestNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyMatchingDonorsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public BloodRequest $bloodRequest
    ) {}

    public function handle(): void
    {
        // Find all eligible donors with matching blood group
        $donors = Donor::where('blood_group', $this->bloodRequest->blood_group)
            ->where('account_status', 'verified')
            ->where('eligibility_status', 'eligible')
            ->whereRaw('DATEDIFF(CURDATE(), last_donation_date) >= 56 OR last_donation_date IS NULL')
            ->get();

        foreach ($donors as $donor) {
            if ($donor->user) {
                $donor->user->notify(new BloodRequestNotification($this->bloodRequest, 'created'));
            }
        }
    }
}