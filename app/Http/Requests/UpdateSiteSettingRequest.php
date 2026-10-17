<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand_part_1' => ['required', 'string', 'max:100'],
            'brand_part_2' => ['required', 'string', 'max:100'],
            'brand_tagline' => ['required', 'string', 'max:191'],
            'consultant_name' => ['required', 'string', 'max:191'],
            'consultant_role' => ['required', 'string', 'max:191'],
            'company_city' => ['required', 'string', 'max:191'],
            'contact_email' => ['required', 'email', 'max:191'],
            'contact_phone' => ['required', 'string', 'max:100'],
            'whatsapp_number' => ['required', 'string', 'max:50'],
            'siscoop3f_url' => ['required', 'url', 'max:500'],
            'telemedicine_url' => ['required', 'url', 'max:500'],
            'footer_description' => ['nullable', 'string', 'max:2000'],
            'footer_copyright' => ['required', 'string', 'max:191'],
            'sim_trial_days' => ['required', 'integer', 'min:0', 'max:365'],
            'sim_savings_share_percent' => ['required', 'integer', 'min:1', 'max:100'],
            'sim_revenue_share_percent' => ['required', 'integer', 'min:1', 'max:100'],
            'sim_user_regular_price' => ['required', 'numeric', 'min:0'],
            'sim_user_partner_price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
