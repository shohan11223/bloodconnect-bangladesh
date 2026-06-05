<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class HospitalApprovalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $hospital,
        public $status = 'approved'
    ) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $subject = $this->status === 'approved' 
            ? 'আপনার হাসপাতাল অনুমোদিত হয়েছে'
            : 'আপনার হাসপাতাল আবেদন প্রত্যাখ্যান করা হয়েছে';

        return (new MailMessage)
            ->subject($subject)
            ->line("হাসপাতালের নাম: {$this->hospital->hospital_name}")
            ->line("লাইসেন্স নম্বর: {$this->hospital->license_number}")
            ->when($this->status === 'approved',
                fn($mail) => $mail->action('ড্যাশবোর্ডে দেখুন', url('/dashboard'))
                    ->line('আপনার হাসপাতাল এখন জনসাধারণের কাছে দৃশ্যমান'),
                fn($mail) => $mail->line("কারণ: {$this->hospital->rejection_reason}")
            )
            ->line('ধন্যবাদ ব্লাডকানেক্ট বাংলাদেশ ব্যবহার করার জন্য');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->status === 'approved' ? 'হাসপাতাল অনুমোদিত' : 'হাসপাতাল প্রত্যাখ্যান করা হয়েছে',
            'message' => "{$this->hospital->hospital_name} - স্থিতি: {$this->status}",
            'hospital_id' => $this->hospital->id,
            'type' => 'hospital',
        ];
    }
}