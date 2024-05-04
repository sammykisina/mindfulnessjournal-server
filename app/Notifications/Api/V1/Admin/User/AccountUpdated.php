<?php

declare(strict_types=1);

namespace App\Notifications\Api\V1\Admin\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountUpdated extends Notification
{
    use Queueable;

    public function __construct(
        public string $password
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Account Details Updated')
            ->greeting('Hello')
            ->line('Your account details have been updated successfully')
            ->line('You can now access your account using the password: '.$this->password)
            ->line('Thank you for using our application!');
    }
}
