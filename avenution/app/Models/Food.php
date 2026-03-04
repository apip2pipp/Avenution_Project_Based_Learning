<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'category',
        'calories',
        'protein',
        'carbs',
        'fat',
        'fiber',
        'description',
        'image_url',
        'dietary_tags',
        'health_benefits',
        'emoji',
    ];

    protected $casts = [
        'dietary_tags' => 'array',
        'health_benefits' => 'array',
    ];

    /**
     * Get the recommendations for the food.
     */
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}
