<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePublicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:191'],
            'subtitle' => ['nullable', 'string', 'max:191'],
            'category' => ['required', 'string', 'max:150'],
            'author' => ['required', 'string', 'max:150'],
            'year' => ['required', 'string', 'max:20'],
            'summary' => ['required', 'string', 'max:2000'],
            'content' => ['nullable', 'string', 'max:6000'],
            'highlights_text' => ['nullable', 'string', 'max:3000'],
            'cta_text' => ['required', 'string', 'max:150'],
            'cta_url' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['required', 'integer'],
        ];
    }
}
