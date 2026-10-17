<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveSectionItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'badge' => ['nullable', 'string', 'max:150'],
            'title' => ['required', 'string', 'max:191'],
            'subtitle' => ['nullable', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:2000'],
            'highlight_metric' => ['nullable', 'string', 'max:100'],
            'icon' => ['required', 'string', 'max:50'],
            'accent_color' => ['required', 'string', 'max:50'],
            'link_text' => ['nullable', 'string', 'max:150'],
            'link_url' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['required', 'integer'],
        ];
    }
}
