<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
        'status',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if user is verified
     */
    public function isVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    /**
     * Get status badge class for display
     */
    public function getStatusBadgeClass(): string
    {
        return $this->status === 'active' ? 'badge-soft-success' : 'badge-soft-danger';
    }

    /**
     * Get role badge class for display
     */
    public function getRoleBadgeClass(): string
    {
        return $this->role === 'admin' ? 'badge-soft-primary' : 'badge-soft-secondary';
    }

    /**
     * Blog-related relationships
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Check if user can create blog posts
     */
    public function canCreateBlog(): bool
    {
        return $this->status === 'active' && $this->email_verified_at !== null;
    }

    /**
     * Check if user can create blog posts (alias)
     */
    public function canCreateBlogs(): bool
    {
        return $this->canCreateBlog();
    }

    /**
     * Check if user can comment
     */
    public function canComment(): bool
    {
        return $this->status === 'active';
    }
}