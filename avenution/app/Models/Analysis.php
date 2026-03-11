<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'age',
        'weight',
        'height',
        'gender',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'blood_sugar',
        'cholesterol',
        'activity_level',
        'dietary_restriction',
        'health_goal',
        'goal',
        'bmi',
        'bmi_category',
        'predicted_diet_type',
        'health_conditions',
        'daily_calorie_target',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'bmi' => 'decimal:2',
        'health_conditions' => 'array',
    ];

    /**
     * Get the user that owns the analysis.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the recommendations for the analysis.
     */
    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}
