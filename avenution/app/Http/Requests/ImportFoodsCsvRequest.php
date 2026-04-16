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
            'import_token' => ['nullable', 'string'],
            'csv_file' => ['required_without:import_token', 'file', 'mimes:csv,txt', 'max:10240'],
            'mapping' => ['nullable', 'array'],
            'mapping.*' => ['nullable', 'string'],
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
