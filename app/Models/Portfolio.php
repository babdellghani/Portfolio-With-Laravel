<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'category',
        'short_description',
        'description',
        'status',
        'date',
        'location',
        'client',
        'link',
    ];

    protected $casts = [
        'category' => 'array',
    ];

    /**
     * Get all unique categories from portfolios status 1.
     */
    public static function getAllCategories()
    {
        $categories = [];
        
        self::whereNotNull('category')
            ->where('category', '!=', '')
            ->where('status', 1)
            ->get()
            ->each(function ($portfolio) use (&$categories) {
                if (is_array($portfolio->category)) {
                    $categories = array_merge($categories, $portfolio->category);
                }
            });
            
        return array_unique($categories);
    }
}