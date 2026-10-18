<?php

namespace Database\Seeders;

use App\Models\ClinicDepartment;
use App\Models\Lead;
use App\Models\PageSection;
use App\Models\Publication;
use App\Models\SectionItem;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Usuário Administrador Padrão
        User::updateOrCreate(
            ['email' => 'admin@integreservice.com.br'],
            [
                'name' => 'Eudemir Bezerra (Admin)',
                'password' => Hash::make('Integre@2026'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Configurações Globais do Portal
        SiteSetting::query()->delete();
        SiteSetting::create([
            'brand_part_1' => 'Integre',
            'brand_part_2' => 'Service',
            'brand_tagline' => 'Rede de Serviços & Tecnologia',
            'logo_path' => '/assets/images/logo-icon.png',
            'consultant_name' => 'Eudemir Bezerra',
            'consultant_role' => 'Consultor & Estrategista Executivo',
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
            'google_verification_code' => null,
            'google_analytics_id' => null,
            'sim_trial_days' => 30,
            'sim_savings_share_percent' => 30,
            'sim_revenue_share_percent' => 30,
            'sim_user_regular_price' => 20.00,
            'sim_user_partner_price' => 10.00,
        ]);

        SectionItem::query()->delete();
        PageSection::query()->delete();

        // SEÇÃO 1: HERO (ENXUTO E DIRETO AO PONTO)
        $hero = PageSection::create([
            'section_key' => 'hero',
            'nav_label' => 'Início',
            'badge_text' => 'REDE INTEGRADA DE SAÚDE DIGITAL, COOPERATIVISMO & GESTÃO',
            'title' => 'Tecnologia e Inteligência que geram',
            'highlighted_word' => 'Resultado Real',
            'subtitle' => 'Unimos gestão cooperativista digital (SISCOOP3F), Telemedicina 24/7, Consultoria Executiva e Base Científica em um único ecossistema.',
            'description' => 'Modelo exclusivo para cooperativas: 30 dias de implantação sem custo e zero desembolso inicial da receita corrente.',
            'primary_cta_text' => 'Solicitar Proposta Comercial',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Conhecer as 4 Soluções',
            'secondary_cta_url' => '#ecossistema',
            'palette' => 'paleta_01',
            'sort_order' => 1,
            'is_active' => true,
            'extra_data' => [
                'stat_1_value' => '4 Soluções',
                'stat_1_label' => 'Integradas em Rede',
                'stat_2_value' => '30 Dias',
                'stat_2_label' => 'Implantação Gratuita',
                'stat_3_value' => 'R$ 0,00',
                'stat_3_label' => 'Desembolso Inicial',
            ],
        ]);

        // SEÇÃO 2: ECOSSISTEMA (4 VERTICAIS CONCISAS)
        $ecosystem = PageSection::create([
            'section_key' => 'ecosystem',
            'nav_label' => 'Ecossistema',
            'badge_text' => 'NOSSAS 4 FRENTES DE ATUAÇÃO',
            'title' => 'Tudo o que sua instituição precisa em',
            'highlighted_word' => 'um único lugar',
            'subtitle' => 'Selecione abaixo uma área de atuação para explorar os recursos de forma rápida e direta.',
            'description' => '',
            'primary_cta_text' => 'Solicitar Diagnóstico',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Ver Modelo SISCOOP3F',
            'secondary_cta_url' => '#siscoop3f',
            'palette' => 'paleta_01',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $ecoItems = [
            [
                'badge' => 'COOPERATIVISMO DIGITAL',
                'title' => 'SISCOOP3F — Gestão Cooperativista',
                'subtitle' => 'Guias digitais, agendamentos e rastreabilidade',
                'description' => 'Elimina filas presenciais com emissão de guias pelo celular, acompanhamento em tempo real e transparência total para a diretoria.',
                'highlight_metric' => '30 Dias Sem Custo',
                'icon' => 'network',
                'accent_color' => 'electric',
                'link_text' => 'Acessar siscoop3f.com.br',
                'link_url' => 'https://siscoop3f.com.br/',
                'sort_order' => 1,
            ],
            [
                'badge' => 'SAÚDE DIGITAL 24/7',
                'title' => 'Plataforma de Telemedicina',
                'subtitle' => 'Consultas por vídeo e receitas digitais ICP-Brasil',
                'description' => 'Atendimento médico ágil no celular ou computador, reduzindo até 80% das idas desnecessárias ao pronto-socorro.',
                'highlight_metric' => 'Acesso Imediato',
                'icon' => 'video',
                'accent_color' => 'turquoise',
                'link_text' => 'Login Telemedicina',
                'link_url' => 'https://app.consulttelemedicia.com.br/login',
                'sort_order' => 2,
            ],
            [
                'badge' => 'ALTA GESTÃO',
                'title' => 'Consultoria, Auditoria & Mentoria',
                'subtitle' => 'Liderança técnica: Eudemir Bezerra',
                'description' => 'Diagnóstico operacional, auditoria de contas e processos e mentoria executiva para blindar o caixa e escalar resultados.',
                'highlight_metric' => 'Governança Sólida',
                'icon' => 'chart-bar',
                'accent_color' => 'royal',
                'link_text' => 'Solicitar Consultoria',
                'link_url' => '#contato',
                'sort_order' => 3,
            ],
            [
                'badge' => 'BASE CIENTÍFICA',
                'title' => 'Livro & Publicações Oficiais',
                'subtitle' => 'Fundamentação intelectual da marca',
                'description' => 'Metodologia própria consolidada em livro e estudos técnicos sobre eficiência em saúde, gestão e cooperativismo.',
                'highlight_metric' => 'Obra Oficial',
                'icon' => 'book-open',
                'accent_color' => 'cyan',
                'link_text' => 'Conhecer o Livro',
                'link_url' => '#ecossistema',
                'sort_order' => 4,
            ],
        ];
        foreach ($ecoItems as $item) {
            $ecosystem->items()->create($item);
        }

        // SEÇÃO 3: IDENTIDADE INSTITUCIONAL (RAZÃO DE EXISTIR, MISSÃO, VISÃO E VALORES)
        PageSection::create([
            'section_key' => 'institutional_identity',
            'nav_label' => 'Identidade Institucional',
            'badge_text' => 'DIRETRIZES ESTRATÉGICAS • GOVERNANÇA & PROPÓSITO',
            'title' => 'A base institucional que guia',
            'highlighted_word' => 'nossa atuação',
            'subtitle' => 'Princípios sólidos de gestão, tecnologia e cooperação que sustentam cada entrega da IntegreService.',
            'description' => '',
            'primary_cta_text' => 'Conhecer Modelo de Parceria',
            'primary_cta_url' => '#siscoop3f',
            'secondary_cta_text' => 'Falar com a Diretoria',
            'secondary_cta_url' => '#contato',
            'palette' => 'paleta_01',
            'sort_order' => 3,
            'is_active' => true,
            'extra_data' => [
                'purpose_label' => 'Razão de Existir',
                'purpose_text' => 'Integrar conhecimento, gestão, tecnologia e serviços especializados para ajudar pessoas e organizações a crescer, melhorar seus resultados e gerar valor sustentável.',
                'mission_label' => 'Missão',
                'mission_text' => 'Desenvolver e integrar soluções empresariais, tecnológicas e de saúde por meio de conhecimento, inovação, consultoria e parcerias estratégicas, promovendo eficiência, acesso e sustentabilidade.',
                'vision_label' => 'Visão',
                'vision_text' => 'Ser reconhecida como uma empresa de referência na integração de negócios, gestão digital, consultoria e soluções de saúde, com atuação regional e capacidade de expansão nacional.',
                'values_label' => 'Valores Institucionais',
                'values_text' => 'Integridade, cooperação, inovação, transparência, excelência técnica, responsabilidade, segurança da informação, compromisso com resultados e valorização das pessoas.',
            ],
        ]);

        // SEÇÃO 4: SISCOOP3F (DIFERENCIAIS DIRETOS)
        $siscoop = PageSection::create([
            'section_key' => 'siscoop3f',
            'nav_label' => 'SISCOOP3F',
            'badge_text' => 'PLATAFORMA SISCOOP3F • GESTÃO DE COOPERATIVAS',
            'title' => 'Modernize sua Cooperativa sem',
            'highlighted_word' => 'Desembolso Inicial',
            'subtitle' => 'A tecnologia deve gerar resultado antes de gerar custo. Implantamos o SISCOOP3F com 30 dias gratuitos de adaptação e remuneração baseada em eficiência.',
            'description' => 'Proposta validada para cooperativas de saúde (Modelo CBSAÚDE).',
            'primary_cta_text' => 'Acessar SISCOOP3F',
            'primary_cta_url' => 'https://siscoop3f.com.br/',
            'secondary_cta_text' => 'Solicitar Carta de Intenção',
            'secondary_cta_url' => '#contato',
            'palette' => 'paleta_03',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        $siscoopItems = [
            [
                'badge' => 'COMODIDADE AO USUÁRIO',
                'title' => 'Guias e Marcações pelo Celular',
                'subtitle' => 'Zero Deslocamento Físico',
                'description' => 'O usuário solicita guias, agenda serviços e acompanha tudo online sem precisar ir até a sede da Cooperativa.',
                'highlight_metric' => '100% Digital',
                'icon' => 'device-mobile',
                'accent_color' => 'electric',
                'sort_order' => 1,
            ],
            [
                'badge' => 'GESTÃO & TRANSPARÊNCIA',
                'title' => 'Rastreabilidade em Tempo Real',
                'subtitle' => 'Controle Total para a Diretoria',
                'description' => 'Visão clara de solicitações, custos operacionais, auditoria de procedimentos e integração com sistemas existentes.',
                'highlight_metric' => 'Tempo Real',
                'icon' => 'shield-check',
                'accent_color' => 'cyan',
                'sort_order' => 2,
            ],
            [
                'badge' => 'TRANSIÇÃO SEGURA',
                'title' => 'Implantação Sem Interrupções',
                'subtitle' => '30 Dias de Testes Sem Custo',
                'description' => 'Parametrização completa, treinamento da equipe e acompanhamento assistido preservando a continuidade dos serviços.',
                'highlight_metric' => '30 Dias Grátis',
                'icon' => 'clock',
                'accent_color' => 'turquoise',
                'sort_order' => 3,
            ],
        ];
        foreach ($siscoopItems as $item) {
            $siscoop->items()->create($item);
        }

        // SEÇÃO 5: MODELO DE INVESTIMENTO (OS 3 PILARES DA CARTA DE INTENÇÃO)
        $investment = PageSection::create([
            'section_key' => 'investment_model',
            'nav_label' => 'Modelo de Parceria',
            'badge_text' => 'MODELO DE INVESTIMENTO INTELIGENTE',
            'title' => 'Remuneração atrelada ao',
            'highlighted_word' => 'Resultado da Cooperativa',
            'subtitle' => 'Sem comprometer a receita corrente inicial da instituição.',
            'description' => '',
            'primary_cta_text' => 'Solicitar Proposta deste Modelo',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Falar no WhatsApp',
            'secondary_cta_url' => '#contato',
            'palette' => 'paleta_03',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        $investmentItems = [
            [
                'badge' => 'ECONOMIA GERADA',
                'title' => '70% da Economia Fica na Cooperativa',
                'subtitle' => 'Apenas 30% sobre valores economizados',
                'description' => 'A IntegreService recebe 30% apenas sobre a redução de custos comprovadamente gerada pela plataforma.',
                'highlight_metric' => '30%',
                'icon' => 'chart-bar',
                'accent_color' => 'cyan',
                'sort_order' => 1,
            ],
            [
                'badge' => 'NOVAS RECEITAS',
                'title' => 'Participação em Novas Oportunidades',
                'subtitle' => '30% sobre novas receitas criadas',
                'description' => 'Criamos novas fontes de receita para a Cooperativa e participamos apenas quando o resultado entra em caixa.',
                'highlight_metric' => '30%',
                'icon' => 'trending-up',
                'accent_color' => 'turquoise',
                'sort_order' => 2,
            ],
            [
                'badge' => 'COMODIDADE DIGITAL (50% OFF)',
                'title' => 'Acesso Digital ao Usuário',
                'subtitle' => 'De R$ 20,00 por R$ 10,00 / usuário',
                'description' => 'Desconto de 50% na parceria consultiva para disponibilizar guias e agendamentos digitais a todos os vinculados.',
                'highlight_metric' => 'R$ 10/mês',
                'icon' => 'sparkles',
                'accent_color' => 'electric',
                'sort_order' => 3,
            ],
        ];
        foreach ($investmentItems as $item) {
            $investment->items()->create($item);
        }

        // SEÇÃO 6: TELEMEDICINA
        $telemedicine = PageSection::create([
            'section_key' => 'telemedicine',
            'nav_label' => 'Telemedicina',
            'badge_text' => 'SAÚDE DIGITAL 24/7',
            'title' => 'Telemedicina Rápida e',
            'highlighted_word' => 'Sem Filas',
            'subtitle' => 'Consultas médicas por vídeo em alta definição com emissão imediata de receitas, atestados e pedidos de exames válidos em todo o Brasil.',
            'description' => '',
            'primary_cta_text' => 'Acessar Plataforma de Telemedicina',
            'primary_cta_url' => 'https://app.consulttelemedicia.com.br/login',
            'secondary_cta_text' => 'Implantar na Minha Instituição',
            'secondary_cta_url' => '#contato',
            'palette' => 'paleta_02',
            'sort_order' => 6,
            'is_active' => true,
        ]);

        $teleItems = [
            [
                'badge' => 'ACESSO WEB & MOBILE',
                'title' => 'Vídeo Consultas Imediatas',
                'subtitle' => 'Sem instalar aplicativos complexos',
                'description' => 'Atendimento humanizado e rápido onde o paciente estiver.',
                'highlight_metric' => 'HD 24/7',
                'icon' => 'video',
                'accent_color' => 'turquoise',
                'sort_order' => 1,
            ],
            [
                'badge' => 'ASSINATURA ICP-BRASIL',
                'title' => 'Prescrição Médica Digital',
                'subtitle' => 'Válida em todas as farmácias',
                'description' => 'Receitas, atestados e solicitações de exames enviados direto no celular.',
                'highlight_metric' => '100% Legal',
                'icon' => 'document-check',
                'accent_color' => 'cyan',
                'sort_order' => 2,
            ],
            [
                'badge' => 'EFICIÊNCIA ASSISTENCIAL',
                'title' => 'Redução de Sinistralidade',
                'subtitle' => 'Triagem clínica inteligente',
                'description' => 'Resolve até 80% dos casos sem sobrecarregar unidades de pronto atendimento.',
                'highlight_metric' => '-Custos',
                'icon' => 'heart-pulse',
                'accent_color' => 'turquoise',
                'sort_order' => 3,
            ],
        ];
        foreach ($teleItems as $item) {
            $telemedicine->items()->create($item);
        }

        // SEÇÃO 7: CONSULTORIA
        $consulting = PageSection::create([
            'section_key' => 'consulting',
            'nav_label' => 'Consultoria',
            'badge_text' => 'INTELIGÊNCIA CORPORATIVA',
            'title' => 'Consultoria, Auditoria e',
            'highlighted_word' => 'Mentoria Executiva',
            'subtitle' => 'Liderada pelo consultor Eudemir Bezerra, apoiamos cooperativas e empresas na governança, auditoria de processos e expansão financeira.',
            'description' => '',
            'primary_cta_text' => 'Agendar Reunião com o Consultor',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Conhecer o Livro',
            'secondary_cta_url' => '#ecossistema',
            'palette' => 'paleta_01',
            'sort_order' => 7,
            'is_active' => true,
        ]);

        $consultingItems = [
            [
                'badge' => 'GESTÃO & PROCESSOS',
                'title' => 'Consultoria Organizacional',
                'subtitle' => 'Reestruturação e Eficiência',
                'description' => 'Redesenho de fluxos operacionais, redução de despesas e implantação de indicadores de desempenho.',
                'highlight_metric' => '+Resultado',
                'icon' => 'briefcase',
                'accent_color' => 'royal',
                'sort_order' => 1,
            ],
            [
                'badge' => 'CONFORMIDADE & CONTAS',
                'title' => 'Auditoria Especializada',
                'subtitle' => 'Segurança e Rastreabilidade',
                'description' => 'Auditoria técnica de contratos, processos internos e contas médicas para estancar perdas financeiras.',
                'highlight_metric' => 'Blindagem',
                'icon' => 'shield-check',
                'accent_color' => 'cyan',
                'sort_order' => 2,
            ],
            [
                'badge' => 'ALTA DIREÇÃO',
                'title' => 'Mentoria Executiva',
                'subtitle' => 'Apoio a Presidentes e Gestores',
                'description' => 'Acompanhamento estratégico para tomada de decisão segura, governança e inovação em cooperativas.',
                'highlight_metric' => 'Liderança',
                'icon' => 'academic-cap',
                'accent_color' => 'turquoise',
                'sort_order' => 3,
            ],
        ];
        foreach ($consultingItems as $item) {
            $consulting->items()->create($item);
        }

        // SEÇÃO 8: LIVRO
        PageSection::create([
            'section_key' => 'book',
            'nav_label' => 'O Livro',
            'badge_text' => 'AUTORIDADE INTELECTUAL',
            'title' => 'O Livro e a Base Científica da',
            'highlighted_word' => 'IntegreService',
            'subtitle' => 'Conhecimento prático e metodológico que fundamenta todas as soluções da nossa rede.',
            'description' => '',
            'primary_cta_text' => 'Solicitar Exemplar ou Apresentação',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Falar com o Autor',
            'secondary_cta_url' => '#contato',
            'palette' => 'paleta_01',
            'sort_order' => 8,
            'is_active' => true,
        ]);

        // SEÇÃO 9: CONTATO
        PageSection::create([
            'section_key' => 'contact',
            'nav_label' => 'Contato',
            'badge_text' => 'ATENDIMENTO EXECUTIVO & COMERCIAL',
            'title' => 'Vamos levar a IntegreService para a',
            'highlighted_word' => 'sua Instituição?',
            'subtitle' => 'Solicite uma proposta personalizada do SISCOOP3F (com 30 dias sem custo), Telemedicina ou Consultoria Executiva.',
            'description' => '',
            'primary_cta_text' => 'Enviar Solicitação',
            'primary_cta_url' => '#form-proposta',
            'secondary_cta_text' => 'Chamar no WhatsApp',
            'secondary_cta_url' => '#whatsapp',
            'palette' => 'paleta_01',
            'sort_order' => 9,
            'is_active' => true,
        ]);

        // 3. Limpa registros antigos de departamentos de clínica (Clínica não entra como serviço)
        ClinicDepartment::query()->delete();

        // 4. Publicações & Livro Oficial (Enxuto)
        Publication::query()->delete();
        $publications = [
            [
                'title' => 'Gestão Integrada, Saúde & Cooperativismo: A Arquitetura da Eficiência',
                'subtitle' => 'A obra que fundamenta a metodologia IntegreService e o sistema SISCOOP3F',
                'category' => 'Livro Oficial',
                'author' => 'Eudemir Bezerra',
                'year' => '2026',
                'summary' => 'Guia prático e científico para presidentes de cooperativas, gestores de saúde e líderes que buscam reduzir custos, implantar tecnologia sem desembolso inicial e elevar a governança.',
                'content' => '',
                'highlights' => [
                    'Como reduzir custos operacionais em cooperativas',
                    'Parcerias tecnológicas baseadas em eficiência (Success Fee)',
                    'Telemedicina e guias digitais na satisfação do usuário',
                    'Auditoria preventiva e rastreabilidade em tempo real',
                ],
                'cta_text' => 'Solicitar Exemplar ou Apresentação',
                'cta_url' => '#contato',
                'is_featured_book' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Modelo CBSAÚDE & SISCOOP3F: Implantação Assistida Sem Desembolso Inicial',
                'subtitle' => 'Estudo de Caso e Viabilidade Econômica',
                'category' => 'Estudo Técnico',
                'author' => 'Eudemir Bezerra',
                'year' => '2026',
                'summary' => 'Demonstração prática do modelo de 30 dias gratuitos de adaptação e comodidade digital aos cooperados por R$ 10/mês.',
                'highlights' => [
                    'Zero comprometimento da receita corrente',
                    'Fim do deslocamento físico para guias',
                ],
                'cta_text' => 'Solicitar Estudo',
                'cta_url' => '#contato',
                'is_featured_book' => false,
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];
        foreach ($publications as $pub) {
            Publication::create($pub);
        }

        // 5. Lead Inicial
        Lead::query()->delete();
        Lead::create([
            'name' => 'Alan Nogueira',
            'organization' => 'CBSAÚDE - Cooperativa de Saúde dos Servidores do CBMAC',
            'role' => 'Diretor Presidente',
            'email' => 'presidencia@cbsaude.com.br',
            'phone' => '(68) 99999-1111',
            'vertical_interest' => 'SISCOOP3F - Gestão Cooperativista',
            'estimated_users' => 1500,
            'message' => 'Carta de Intenção referente à implantação da plataforma tecnológica integrada SISCOOP3F com período inicial de 30 dias de testes sem custo.',
            'status' => 'proposta_enviada',
            'admin_notes' => 'Carta de Intenção formalizada em Rio Branco - Acre pelo consultor Eudemir Bezerra.',
        ]);
    }
}
