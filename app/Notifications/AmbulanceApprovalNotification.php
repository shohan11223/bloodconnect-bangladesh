<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AmbulanceApprovalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $ambulance,
        public $status = 'approved'
    ) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $subject = $this->status === 'approved' 
            ? 'আপনার অ্যাম্বুলেন্স অনুমোদিত হয়েছে'
            : 'আপনার অ্যাম্বুলেন্স আবেদন প্রত্যাখ্যান করা হয়েছে';

        return (new MailMessage)
            ->subject($subject)
            ->line("অ্যাম্বুলেন্স নাম: {$this->ambulance->ambulance_name}")
            ->line("গাড়ির নম্বর: {$this->ambulance->vehicle_number}")
            ->when($this->status === 'approved',
                fn($mail) => $mail->action('ড্যাশবোর্ডে দেখুন', url('/dashboard'))
                    ->line('আপনার অ্যাম্বুলেন্স এখন জনসাধারণের কাছে দৃশ্যমান'),
                fn($mail) => $mail->line("কারণ: {$this->ambulance->rejection_reason}")
            )
            ->line('ধন্যবাদ ব্লাডকানেক্ট বাংলাদেশ ব্যবহার করার জন্য');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->status === 'approved' ? 'অ্যাম্বুলেন্স অনুমোদিত' : 'অ্যাম্বুলেন্স প্রত্যাখ্যান করা হয়েছে',
            'message' => "{$this->ambulance->ambulance_name} - স্থিতি: {$this->status}",
            'ambulance_id' => $this->ambulance->id,
            'type' => 'ambulance',
        ];
    }
}