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
     * Get all portfolios
     */
    public static function getAllPortfolios()
    {
        return self::all();
    }

    /**
     * Get all unique categories from portfolios
     */
    public static function getAllCategories()
    {
        return self::whereNotNull('category')
            ->where('category', '!=', '')
            ->pluck('category')
            ->unique()
            ->values()
            ->toArray();
    }
}