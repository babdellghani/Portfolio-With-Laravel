<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'is_read',
        'is_replied',
        'admin_reply',
        'replied_at',
    ];

    protected $casts = [
        'is_read'    => 'boolean',
        'is_replied' => 'boolean',
        'replied_at' => 'datetime',
    ];

    /**
     * Get unread messages count
     */
    public static function getUnreadCount()
    {
        return static::where('is_read', false)->count();
    }

    /**
     * Get recent unread messages
     */
    public static function getRecentUnread($limit = 5)
    {
        return static::where('is_read', false)
            ->latest()
            ->limit($limit)
            ->get();
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    /**
     * Mark as replied
     */
    public function markAsReplied($reply)
    {
        $this->update([
            'is_replied'  => true,
            'admin_reply' => $reply,
            'replied_at'  => now(),
            'is_read'     => true,
        ]);
    }
}
