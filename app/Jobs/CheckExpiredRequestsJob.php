<?php

namespace App\Jobs;

use App\Models\BloodRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckExpiredRequestsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Find all expired blood requests
        BloodRequest::where('status', '!=', 'fulfilled')
            ->where('status', '!=', 'cancelled')
            ->where('expires_at', '<=', now())
            ->update(['status' => 'expired']);

        \Log::info('Expired blood requests checked and marked as expired');
    }
}