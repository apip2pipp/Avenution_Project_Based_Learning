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
        'sugars',
        'sodium',
        'cholesterol',
        'meal_type',
        'dietary_tags',
        'health_benefits',
        'emoji',
    ];

    protected $casts = [
        'dietary_tags' => 'array',
        'health_benefits' => 'array',
    ];

    /**
     * Get emoji for the food's category
     * 
     * @return string
     */
    public function getEmojiAttribute(): string
    {
        return config('food-categories.categories.' . $this->category, '🍽️');
    }

    /**
     * Get the recommendations for the food.
     */
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}
