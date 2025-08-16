<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentUpdated extends Notification
{
    use Queueable;

    public $comment;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment, User $user)
    {
        $this->comment = $comment;
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
            ->subject('Comment Updated - ' . config('app.name'))
            ->greeting('Hello Admin!')
            ->line('A comment has been updated.')
            ->line('Comment Details:')
            ->line('Author: ' . $this->user->name)
            ->line('Blog: ' . $this->comment->blog->title)
            ->line('Comment: ' . substr($this->comment->content, 0, 100) . '...')
            ->line('Updated: ' . $this->comment->updated_at->format('M d, Y h:i A'))
            ->action('View Comments', route('admin.comments.index'))
            ->line('Please review the updated comment.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type'         => 'comment_updated',
            'comment_id'   => $this->comment->id,
            'blog_id'      => $this->comment->blog_id,
            'blog_title'   => $this->comment->blog->title,
            'user_id'      => $this->user->id,
            'user_name'    => $this->user->name,
            'content'      => substr($this->comment->content, 0, 100),
            'status'       => $this->comment->status,
            'message'      => $this->user->name . ' updated a comment on "' . $this->comment->blog->title . '"',
            'action_url'   => route('admin.comments.index'),
        ];
    }
}
