<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class SchoolVerifyEmailNotification extends VerifyEmail
{
    /**
     * Get the verification URL for the given user.
     */
    protected function verificationUrl($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'verification.verify',  // Laravel's default verification route
            Carbon::now()->addMinutes(config('auth.verification.expire', 60)),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );

        // Modify the URL to include "/School"
        return str_replace('/verify-email', '/School/verify-email', $url);
    }

    /**
     * Build the mail message.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verify Your School Email')
            ->line('Click the button below to verify your email address.')
            ->action('Verify Email', $this->verificationUrl($notifiable))
            ->line('If you did not create an account, no further action is required.');
    }
}
