<?php

namespace App\Exports\Sheets;

use App\Models\Recommendation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class AnalysisRecommendationDetailSheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle
{
    public function collection(): Collection
    {
        return Recommendation::with(['analysis.user', 'food'])
            ->latest()
            ->get();
    }

    public function title(): string
    {
        return 'Recommendation Details';
    }

    public function headings(): array
    {
        return [
            'Recommendation ID',
            'Created At',
            'Analysis ID',
            'Session ID',
            'User Name',
            'Username',
            'Email',
            'Goal',
            'BMI',
            'BMI Category',
            'Predicted Diet Type',
            'Food ID',
            'Food Name',
            'Food Category',
            'Timing',
            'Match Score',
            'Food Calories',
            'Food Protein',
            'Food Carbs',
            'Food Fat',
            'Food Fiber',
        ];
    }

    public function map($recommendation): array
    {
        $analysis = $recommendation->analysis;
        $user = $analysis?->user;
        $food = $recommendation->food;

        return [
            $recommendation->id,
            optional($recommendation->created_at)->toDateTimeString(),
            $analysis?->id,
            $analysis?->session_id,
            $user?->name ?? 'Guest',
            $user?->username ?? '-',
            $user?->email ?? '-',
            $analysis?->goal,
            $analysis?->bmi,
            $analysis?->bmi_category,
            $analysis?->predicted_diet_type,
            $food?->id,
            $food?->name,
            $food?->category,
            $recommendation->timing,
            $recommendation->match_score,
            $food?->calories,
            $food?->protein,
            $food?->carbs,
            $food?->fat,
            $food?->fiber,
        ];
    }
}
