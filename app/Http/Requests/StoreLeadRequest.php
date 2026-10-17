<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'organization' => ['nullable', 'string', 'max:191'],
            'role' => ['nullable', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191'],
            'phone' => ['required', 'string', 'max:60'],
            'vertical_interest' => ['required', 'string', 'max:191'],
            'estimated_users' => ['nullable', 'integer', 'min:1'],
            'message' => ['nullable', 'string', 'max:3000'],
        ];
    }
}
