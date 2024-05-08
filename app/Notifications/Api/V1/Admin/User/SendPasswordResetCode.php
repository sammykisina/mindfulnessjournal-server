<?php

declare(strict_types=1);

namespace App\Notifications\Api\V1\Admin\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendPasswordResetCode extends Notification
{
    use Queueable;

    public function __construct(

    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Password reset code')
            ->greeting('Hello')
            ->line('Your password reset code is ' . $notifiable->two_factor_code)
            ->line('This code will expire in 10 minutes')
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
