<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        // Only allow admins to access unread count
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            return 0; // Return 0 instead of throwing exception to avoid breaking the UI
        }

        return static::where('is_read', false)->count();
    }

    /**
     * Get recent unread messages
     */
    public static function getRecentUnread($limit = 5)
    {
        // Only allow admins to access recent unread messages
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            return collect(); // Return empty collection instead of throwing exception
        }

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
