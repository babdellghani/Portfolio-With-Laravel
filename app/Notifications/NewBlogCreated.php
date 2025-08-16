<?php

namespace App\Notifications;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBlogCreated extends Notification
{
    use Queueable;

    public $blog;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Blog $blog, User $user)
    {
        $this->blog = $blog;
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
            ->subject('New Blog Post Created - ' . config('app.name'))
            ->greeting('Hello Admin!')
            ->line('A new blog post has been created.')
            ->line('Blog Details:')
            ->line('Title: ' . $this->blog->title)
            ->line('Author: ' . $this->user->name)
            ->line('Status: ' . ucfirst($this->blog->status))
            ->line('Created: ' . $this->blog->created_at->format('M d, Y h:i A'))
            ->action('View Blog Posts', route('admin.blogs.index'))
            ->line('Please review the new blog post.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'blog_created',
            'blog_id'    => $this->blog->id,
            'blog_title' => $this->blog->title,
            'blog_slug'  => $this->blog->slug,
            'user_id'    => $this->user->id,
            'user_name'  => $this->user->name,
            'status'     => $this->blog->status,
            'message'    => $this->user->name . ' created a new blog post: "' . $this->blog->title . '"',
            'action_url' => route('admin.blogs.index'),
        ];
    }
}
