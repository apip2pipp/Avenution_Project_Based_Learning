<?php

namespace App\Exports\Sheets;

use App\Models\Analysis;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class AnalysisSummarySheet implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithTitle
{
    public function collection(): Collection
    {
        return Analysis::with(['user', 'recommendations.food'])
            ->latest()
            ->get();
    }

    public function title(): string
    {
        return 'Summary';
    }

    public function headings(): array
    {
        return [
            'Analysis ID',
            'Session ID',
            'Created At',
            'User Name',
            'Username',
            'Email',
            'Phone',
            'Age',
            'Gender',
            'Weight (kg)',
            'Height (cm)',
            'BMI',
            'BMI Category',
            'Blood Pressure Systolic',
            'Blood Pressure Diastolic',
            'Blood Sugar',
            'Cholesterol',
            'Activity Level',
            'Dietary Restriction',
            'Health Goal',
            'Predicted Diet Type',
            'Health Conditions',
            'Daily Calorie Target',
            'Recommendation Count',
            'Recommendations',
        ];
    }

    public function map($analysis): array
    {
        $user = $analysis->user;
        $healthConditions = $analysis->health_conditions;

        if (is_string($healthConditions)) {
            $decodedConditions = json_decode($healthConditions, true);
            $healthConditions = json_last_error() === JSON_ERROR_NONE ? $decodedConditions : [$healthConditions];
        }

        if (! is_array($healthConditions)) {
            $healthConditions = $healthConditions ? [$healthConditions] : [];
        }

        $recommendations = $analysis->recommendations->map(function ($recommendation) {
            $foodName = $recommendation->food?->name ?? 'Unknown food';
            $matchScore = number_format((float) $recommendation->match_score, 0);

            return trim($recommendation->timing . ': ' . $foodName . ' (' . $matchScore . '%)');
        })->implode(' | ');

        return [
            $analysis->id,
            $analysis->session_id,
            optional($analysis->created_at)->toDateTimeString(),
            $user?->name ?? 'Guest',
            $user?->username ?? '-',
            $user?->email ?? '-',
            $user?->phone ?? '-',
            $analysis->age,
            $analysis->gender,
            $analysis->weight,
            $analysis->height,
            number_format((float) $analysis->bmi, 2),
            $analysis->bmi_category,
            $analysis->blood_pressure_systolic,
            $analysis->blood_pressure_diastolic,
            $analysis->blood_sugar,
            $analysis->cholesterol,
            $analysis->activity_level,
            $analysis->dietary_restriction,
            $analysis->goal,
            $analysis->predicted_diet_type,
            implode(', ', $healthConditions),
            $analysis->daily_calorie_target,
            $analysis->recommendations->count(),
            $recommendations,
        ];
    }
}
