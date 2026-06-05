<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class BloodRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $bloodRequest,
        public $type = 'created'
    ) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $subject = match($this->type) {
            'created' => "জরুরি রক্তের অনুরোধ - {$this->bloodRequest->blood_group}",
            'fulfilled' => 'রক্তের অনুরোধ পূরণ করা হয়েছে',
            default => 'রক্ত অনুরোধ আপডেট'
        };

        return (new MailMessage)
            ->subject($subject)
            ->line("রোগীর নাম: {$this->bloodRequest->receiver->patient_name}")
            ->line("রক্তের গ্রুপ: {$this->bloodRequest->blood_group}")
            ->line("প্রয়োজনীয় পরিমাণ: {$this->bloodRequest->quantity_needed} ব্যাগ")
            ->line("হাসপাতাল: {$this->bloodRequest->receiver->hospital_name}")
            ->action('বিস্তারিত দেখুন', url("/blood-requests/{$this->bloodRequest->id}"))
            ->line('ধন্যবাদ ব্লাডকানেক্ট বাংলাদেশ ব্যবহার করার জন্য');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => "জরুরি রক্তের অনুরোধ",
            'message' => "{$this->bloodRequest->blood_group} রক্তের {$this->bloodRequest->quantity_needed} ব্যাগ প্রয়োজন",
            'blood_request_id' => $this->bloodRequest->id,
            'type' => 'blood_request',
        ];
    }
}