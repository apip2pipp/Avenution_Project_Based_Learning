<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnalyzeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Anyone can analyze (guest or auth)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'age' => 'required|integer|min:1|max:120',
            'weight' => 'required|numeric|min:20|max:300',
            'height' => 'required|numeric|min:50|max:250',
            'gender' => 'required|in:male,female',
            'blood_pressure_systolic' => 'required|integer|min:70|max:200',
            'blood_pressure_diastolic' => 'required|integer|min:40|max:130',
            'blood_sugar' => 'required|integer|min:50|max:400',
            'cholesterol' => 'required|integer|min:100|max:400',
            'activity_level' => 'required|in:low,moderate,high',
            'dietary_restriction' => 'required|in:none,vegetarian,vegan,gluten-free',
            'health_goal' => 'required|in:balanced,weight_loss,muscle_gain,heart_health',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    public function attributes(): array
    {
        return [
            'blood_pressure_systolic' => 'systolic blood pressure',
            'blood_pressure_diastolic' => 'diastolic blood pressure',
            'blood_sugar' => 'blood sugar level',
            'cholesterol' => 'cholesterol level',
            'activity_level' => 'activity level',
            'dietary_restriction' => 'dietary restriction',
            'health_goal' => 'health goal',
        ];
    }
}
