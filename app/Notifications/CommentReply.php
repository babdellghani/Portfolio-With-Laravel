<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentReply extends Notification
{
    use Queueable;

    protected $reply;
    protected $replier;
    protected $originalComment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $reply, User $replier, Comment $originalComment)
    {
        $this->reply = $reply;
        $this->replier = $replier;
        $this->originalComment = $originalComment;
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
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'comment_reply',
            'message' => $this->replier->name . ' replied to your comment on "' . $this->originalComment->blog->title . '"',
            'reply_id' => $this->reply->id,
            'original_comment_id' => $this->originalComment->id,
            'blog_id' => $this->originalComment->blog_id,
            'blog_slug' => $this->originalComment->blog->slug,
            'replier_id' => $this->replier->id,
            'replier_name' => $this->replier->name,
            'blog_title' => $this->originalComment->blog->title,
            'reply_content' => substr($this->reply->content, 0, 100) . (strlen($this->reply->content) > 100 ? '...' : ''),
        ];
    }
}
