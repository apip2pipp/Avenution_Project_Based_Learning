<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportFoodsCsvRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'csv_file.required' => 'File CSV wajib dipilih.',
            'csv_file.file' => 'Input harus berupa file.',
            'csv_file.mimes' => 'Format file harus CSV.',
            'csv_file.max' => 'Ukuran file maksimal 10MB.',
        ];
    }
}
