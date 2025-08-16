<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserRegistered extends Notification
{
    use Queueable;

    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New User Registration - ' . config('app.name'))
            ->greeting('Hello Admin!')
            ->line('A new user has registered on your website.')
            ->line('User Details:')
            ->line('Name: ' . $this->user->name)
            ->line('Email: ' . $this->user->email)
            ->line('Username: ' . $this->user->username)
            ->line('Registration Date: ' . $this->user->created_at->format('M d, Y h:i A'))
            ->action('View User Management', route('users.index'))
            ->line('Please review the new user account.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'user_registration',
            'user_id'    => $this->user->id,
            'user_name'  => $this->user->name,
            'user_email' => $this->user->email,
            'message'    => 'New user "' . $this->user->name . '" has registered.',
            'action_url' => route('users.index'),
        ];
    }
}
