<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'admin_id',
        'message',
    ];

    /**
     * Get the contact that this reply belongs to
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the admin who sent this reply
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
