<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorMail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
   
    public function __construct()
    {
       
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('كود تحقق بخطوتين')
                    ->line('كود التحقق المرسل لك هو' . $notifiable->Code)
                    ->action('تاكيد الدخول', route('tow_factor.index'))
                    ->line('Thank you for using Alwans billing management website!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
