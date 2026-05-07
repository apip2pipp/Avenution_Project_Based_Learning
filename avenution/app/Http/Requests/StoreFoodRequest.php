<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFoodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Admin middleware handles authorization
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $dietaryTags = config('food-label-options.dietary_tags', []);
        $healthBenefits = config('food-label-options.health_benefits', []);

        return [
            'name' => 'required|string|max:255',
            'category' => 'required|in:Protein Hewani,Protein Nabati,Karbohidrat,Sayuran,Buah,Dairy,Lainnya',
            'calories' => 'required|integer|min:0|max:2000',
            'protein' => 'required|numeric|min:0|max:200',
            'carbs' => 'required|numeric|min:0|max:300',
            'fat' => 'required|numeric|min:0|max:200',
            'fiber' => 'nullable|numeric|min:0|max:50',
            'sugars' => 'nullable|numeric|min:0|max:200',
            'sodium' => 'nullable|numeric|min:0|max:5000',
            'cholesterol' => 'nullable|numeric|min:0|max:500',
            'meal_type' => 'nullable|string|max:255',
            'dietary_tags' => ['nullable', 'array'],
            'dietary_tags.*' => ['string', Rule::in($dietaryTags)],
            'health_benefits' => ['nullable', 'array'],
            'health_benefits.*' => ['string', Rule::in($healthBenefits)],
        ];
    }


}
