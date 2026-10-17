<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveClinicDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'custom_tagline' => ['required', 'string', 'max:191'],
            'badge' => ['nullable', 'string', 'max:150'],
            'short_description' => ['required', 'string', 'max:1000'],
            'full_description' => ['nullable', 'string', 'max:4000'],
            'features_text' => ['nullable', 'string', 'max:3000'],
            'icon' => ['required', 'string', 'max:50'],
            'cta_text' => ['required', 'string', 'max:150'],
            'sort_order' => ['required', 'integer'],
        ];
    }
}
