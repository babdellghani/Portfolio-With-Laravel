<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
        'status',
        'user_id',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeWithBlogCount($query)
    {
        return $query->withCount('blogs');
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class);
    }

    // Helper Methods
    public function getStatusTextAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function getBlogsCountAttribute()
    {
        return $this->blogs()->count();
    }
}
