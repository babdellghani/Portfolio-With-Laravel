<?php
namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminRepliedToContact extends Notification
{
    use Queueable;

    public $contact;

    /**
     * Create a new notification instance.
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // Only database notifications, no email
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type'            => 'admin_reply',
            'message'         => 'Admin replied to your contact message',
            'contact_id'      => $this->contact->id,
            'contact_name'    => $this->contact->name,
            'contact_message' => substr($this->contact->message, 0, 100) . '...',
            'admin_reply'     => substr($this->contact->admin_reply, 0, 100) . '...',
            'replied_at'      => $this->contact->replied_at?->format('Y-m-d H:i:s'),
        ];
    }
}
