<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'short_description',
        'description',
        'thumbnail',
        'image',
        'status',
        'views',
        'user_id',
    ];

    protected $casts = [
        'status' => 'string', // 'draft' or 'published'
    ];

    // Relationships
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->with('replies');
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // Scopes
    public function scopePublished(Builder $query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft(Builder $query)
    {
        return $query->where('status', 'draft');
    }

    // Helper methods
    public function isLikedBy($user)
    {
        if (! $user) {
            return false;
        }

        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function isBookmarkedBy($user)
    {
        if (! $user) {
            return false;
        }

        return $this->bookmarks()->where('user_id', $user->id)->exists();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function getCommentsCountAttribute()
    {
        return $this->allComments()->where('status', true)->count();
    }

    public function getBookmarksCountAttribute()
    {
        return $this->bookmarks()->count();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (! $blog->slug) {
                $blog->slug = Str::slug($blog->title);
            }
        });
    }
}