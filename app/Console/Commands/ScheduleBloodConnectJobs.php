<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CheckExpiredReceiversJob;
use App\Jobs\CheckExpiredRequestsJob;
use App\Jobs\NotifyMatchingDonorsJob;

class ScheduleBloodConnectJobs extends Command
{
    protected $signature = 'bloodconnect:schedule';
    protected $description = 'Setup scheduled jobs for BloodConnect Bangladesh';

    public function handle()
    {
        $this->info('ব্লাডকানেক্ট স্বয়ংক্রিয় কাজ সেটআপ করা হচ্ছে...');
        $this->info('আপনার app/Console/Kernel.php এ যোগ করুন:');
        echo PHP_EOL . '$schedule->job(new CheckExpiredReceiversJob)->everyMinute();' . PHP_EOL;
        echo '$schedule->job(new CheckExpiredRequestsJob)->hourly();' . PHP_EOL;
        $this->info('এবং php artisan schedule:work চালান');
    }
}
