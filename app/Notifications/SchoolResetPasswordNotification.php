<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SchoolResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reset Your School Password')
            ->line('You are receiving this email because we received a password reset request for your school account.')
            ->action('Reset Password', url('/School/reset-password/' . $this->token . '?email=' . urlencode($notifiable->email)))
            ->line('If you did not request a password reset, no further action is required.');
    }
}

