<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'analysis_id',
        'food_id',
        'match_score',
        'timing',
    ];

    /**
     * Get the analysis that owns the recommendation.
     */
    public function analysis()
    {
        return $this->belongsTo(Analysis::class);
    }

    /**
     * Get the food associated with the recommendation.
     */
    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
