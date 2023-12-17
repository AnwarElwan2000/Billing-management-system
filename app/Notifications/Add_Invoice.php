<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Add_Invoice extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private $Invoice_Id;
    private $user_name;
    public function __construct($Invoice_Id,$user_name)
    {
      $this->Invoice_Id = $Invoice_Id;
      $this->user_name = $user_name;
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
        $url = 'http://localhost/Bills/public/invoice_details/' . $this->Invoice_Id;
        return (new MailMessage)
                    ->subject('Elwan.com')
                    ->greeting('Welcome ' . $this->user_name)
                    ->line('اضافة فاتورة جديدة')
                    ->action('Show Invoice', $url)
                    ->line('شكرا لاستخدامك موقع علوان لادارة الفواتير');
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
