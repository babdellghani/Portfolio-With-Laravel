<?php

namespace App\Notifications;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TagUpdated extends Notification
{
    use Queueable;

    public $tag;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Tag $tag, User $user)
    {
        $this->tag = $tag;
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
            ->subject('Tag Updated - ' . config('app.name'))
            ->greeting('Hello Admin!')
            ->line('A tag has been updated.')
            ->line('Tag Details:')
            ->line('Name: ' . $this->tag->name)
            ->line('Updated by: ' . $this->user->name)
            ->line('Status: ' . ($this->tag->status ? 'Active' : 'Inactive'))
            ->line('Updated: ' . $this->tag->updated_at->format('M d, Y h:i A'))
            ->action('View Tags', route('admin.tags.index'))
            ->line('Please review the updated tag.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type'      => 'tag_updated',
            'tag_id'    => $this->tag->id,
            'tag_name'  => $this->tag->name,
            'tag_slug'  => $this->tag->slug,
            'user_id'   => $this->user->id,
            'user_name' => $this->user->name,
            'status'    => $this->tag->status,
            'message'   => $this->user->name . ' updated the tag: "' . $this->tag->name . '"',
            'action_url' => route('admin.tags.index'),
        ];
    }
}
