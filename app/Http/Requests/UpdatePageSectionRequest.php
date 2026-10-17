<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nav_label' => ['nullable', 'string', 'max:100'],
            'badge_text' => ['nullable', 'string', 'max:191'],
            'title' => ['nullable', 'string', 'max:191'],
            'highlighted_word' => ['nullable', 'string', 'max:191'],
            'subtitle' => ['nullable', 'string', 'max:2000'],
            'description' => ['nullable', 'string', 'max:5000'],
            'primary_cta_text' => ['nullable', 'string', 'max:150'],
            'primary_cta_url' => ['nullable', 'string', 'max:500'],
            'secondary_cta_text' => ['nullable', 'string', 'max:150'],
            'secondary_cta_url' => ['nullable', 'string', 'max:500'],
            'palette' => ['required', 'in:paleta_01,paleta_02,paleta_03'],
            'sort_order' => ['required', 'integer'],
        ];
    }
}
