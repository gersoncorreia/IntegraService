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
            'consultant_role' => 'Direção Executiva - IntegreService',
            'company_city' => 'Rio Branco - Acre',
            'legal_name' => 'IntegreService — Rede de Serviços & Tecnologia',
            'cnpj' => null,
            'contact_email' => 'contato@integreservice.com.br',
            'contact_phone' => '(68) 99999-0000',
            'whatsapp_number' => '5568999990000',
            'siscoop3f_url' => 'https://siscoop3f.com.br/',
            'telemedicine_url' => 'https://app.consulttelemedicia.com.br/login',
            'footer_description' => 'Conectamos tecnologia, gestão, saúde digital e conhecimento para apoiar o desenvolvimento de instituições e organizações.',
            'footer_copyright' => 'IntegreService - Todos os direitos reservados.',
            'privacy_policy_text' => "A IntegreService respeita a sua privacidade e realiza o tratamento de dados pessoais em conformidade com a Lei Geral de Proteção de Dados (Lei nº 13.709/2018 — LGPD).\n\n1. Finalidade da Coleta: Os dados informados no formulário de contato (nome completo, instituição, telefone/WhatsApp, e-mail e solução de interesse) são utilizados exclusivamente para responder à sua solicitação de apresentação, diagnóstico institucional ou proposta técnica e comercial.\n\n2. Compartilhamento e Segurança: Não comercializamos dados pessoais com terceiros. Adotamos medidas técnicas e administrativas para proteger as informações contra acessos não autorizados.\n\n3. Direitos do Titular e Contato: A qualquer momento você pode solicitar a confirmação, atualização ou exclusão de seus dados de contato enviando mensagem para nosso canal oficial: contato@integreservice.com.br.",
            'seo_title' => 'IntegreService | Tecnologia, Gestão e Saúde Digital',
            'seo_description' => 'Integramos tecnologia, gestão cooperativista (SISCOOP3F), telemedicina e consultoria estratégica para ajudar cooperativas, empresas e instituições públicas a modernizar processos e melhorar sua eficiência operacional.',
            'seo_keywords' => 'IntegreService, SISCOOP3F, gestão cooperativista, telemedicina 24/7, consultoria executiva, base científica, soluções para gestão pública, Eudemir Bezerra, Rio Branco Acre',
            'og_image_path' => '/assets/images/logo-icon.png',
            'sim_trial_days' => 30,
            'sim_savings_share_percent' => 30,
            'sim_revenue_share_percent' => 30,
            'sim_user_regular_price' => 20.00,
            'sim_user_partner_price' => 10.00,
        ]);
    }
}
