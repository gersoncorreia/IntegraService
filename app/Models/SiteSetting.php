<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'sim_trial_days' => 'integer',
        'sim_savings_share_percent' => 'integer',
        'sim_revenue_share_percent' => 'integer',
        'sim_user_regular_price' => 'decimal:2',
        'sim_user_partner_price' => 'decimal:2',
    ];

    public static function current(): self
    {
        return static::first() ?? new self([
            'brand_part_1' => 'Integre',
            'brand_part_2' => 'Service',
            'brand_tagline' => 'Rede de Serviços & Tecnologia',
            'logo_path' => '/assets/images/logo-icon.png',
            'consultant_name' => 'Eudemir Bezerra',
            'consultant_role' => 'Consultor & Estrategista',
            'company_city' => 'Rio Branco - Acre',
            'contact_email' => 'contato@integreservice.com.br',
            'contact_phone' => '(68) 99999-0000',
            'whatsapp_number' => '5568999990000',
            'siscoop3f_url' => 'https://siscoop3f.com.br/',
            'telemedicine_url' => 'https://app.consulttelemedicia.com.br/login',
            'footer_description' => 'Hub centralizador de gestão cooperativista (SISCOOP3F), Telemedicina 24/7, Consultoria Executiva e Autoridade Científica.',
            'footer_copyright' => 'IntegreService (IS) — Rede de Serviços & Tecnologia. Todos os direitos reservados.',
            'seo_title' => 'IntegreService (IS) — Gestão Cooperativista (SISCOOP3F), Telemedicina 24/7 & Consultoria Executiva',
            'seo_description' => 'IntegreService: Rede integrada de gestão cooperativista digital (SISCOOP3F com 30 dias sem custo), Telemedicina 24/7, Consultoria, Auditoria e Mentoria Executiva em Rio Branco - Acre e em todo o Brasil.',
            'seo_keywords' => 'IntegreService, SISCOOP3F, gestão de cooperativas, cooperativa de saúde, telemedicina 24h, consultoria executiva, auditoria em saúde, mentoria empresarial, Eudemir Bezerra, CBSAÚDE, Rio Branco Acre, guias médicas digitais',
            'og_image_path' => '/assets/images/logo-icon.png',
            'sim_trial_days' => 30,
            'sim_savings_share_percent' => 30,
            'sim_revenue_share_percent' => 30,
            'sim_user_regular_price' => 20.00,
            'sim_user_partner_price' => 10.00,
        ]);
    }
}
