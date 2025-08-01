<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'message',
        'image',
        'rating',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'rating' => 'integer',
    ];
}
