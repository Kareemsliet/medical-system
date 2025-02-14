<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;
    /**
     * Create a new notification instance.
     */
     public $code;
     public $user_name;
     public function __construct($code,$user_name)
    {
        $this->code = $code;
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
        return (new MailMessage)->markdown('mail.reset-password',[
            "code"=>$this->code,
            "user_name"=>$this->user_name
        ]);
    }
}
