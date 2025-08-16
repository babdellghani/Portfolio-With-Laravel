<?php

namespace App\Notifications;

use App\Models\Category;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CategoryUpdated extends Notification
{
    use Queueable;

    public $category;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Category $category, User $user)
    {
        $this->category = $category;
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
            ->subject('Category Updated - ' . config('app.name'))
            ->greeting('Hello Admin!')
            ->line('A category has been updated.')
            ->line('Category Details:')
            ->line('Name: ' . $this->category->name)
            ->line('Updated by: ' . $this->user->name)
            ->line('Status: ' . ($this->category->status ? 'Active' : 'Inactive'))
            ->line('Updated: ' . $this->category->updated_at->format('M d, Y h:i A'))
            ->action('View Categories', route('admin.categories.index'))
            ->line('Please review the updated category.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type'          => 'category_updated',
            'category_id'   => $this->category->id,
            'category_name' => $this->category->name,
            'category_slug' => $this->category->slug,
            'user_id'       => $this->user->id,
            'user_name'     => $this->user->name,
            'status'        => $this->category->status,
            'message'       => $this->user->name . ' updated the category: "' . $this->category->name . '"',
            'action_url'    => route('admin.categories.index'),
        ];
    }
}
