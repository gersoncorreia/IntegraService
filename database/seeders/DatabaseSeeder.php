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
        // 1. Usuários Administradores
        User::updateOrCreate(
            ['email' => 'gersoncorreia12@gmail.com'],
            [
                'name' => 'Gerson Correia',
                'password' => Hash::make('ger809514'),
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@integreservice.com.br'],
            [
                'name' => 'Eudemir Bezerra (Admin)',
                'password' => Hash::make('Integre@2026'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Configurações Globais do Portal (Textos Oficiais da Reformulação)
        SiteSetting::query()->delete();
        SiteSetting::create([
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
            'privacy_policy_text' => "A IntegreService respeita a sua privacidade e realiza o tratamento de dados pessoais em conformidade com a Lei Geral de Proteção de Dados (Lei nº 13.709/2018 — LGPD).\n\n1. Finalidade da Coleta: Os dados informados no formulário de contato (nome completo, nome da instituição, telefone/WhatsApp, e-mail opcional e solução de interesse) são utilizados exclusivamente para responder à sua solicitação de apresentação institucional, diagnóstico preliminar ou elaboração de proposta técnica e comercial.\n\n2. Compartilhamento e Segurança da Informação: Não comercializamos ou cedemos dados pessoais a terceiros. Adotamos controles técnicos e administrativos para preservar a confidencialidade e a integridade das informações.\n\n3. Escopo de Saúde Digital e Contratações Públicas: Nos projetos que envolvam telemedicina ou gestão pública, o tratamento de dados observa estritamente os protocolos assistenciais aplicáveis, o sigilo profissional e as normas legais vigentes.\n\n4. Direitos do Titular e Canal de Atendimento: Você pode solicitar a confirmação, atualização ou exclusão de seus dados de contato a qualquer momento pelo e-mail oficial: contato@integreservice.com.br.",
            'seo_title' => 'IntegreService | Tecnologia, Gestão e Saúde Digital',
            'seo_description' => 'Integramos tecnologia, gestão cooperativista (SISCOOP3F), telemedicina e consultoria estratégica para ajudar cooperativas, empresas e instituições a modernizar processos, ampliar o acesso aos serviços e melhorar sua eficiência operacional.',
            'seo_keywords' => 'IntegreService, SISCOOP3F, gestão cooperativista, telemedicina 24/7, consultoria executiva, base científica, soluções para gestão pública, Eudemir Bezerra, Rio Branco Acre',
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

        // SEÇÃO 1: HERO (Seção 6.1 do Diagnóstico — Abertura Institucional Clara e Segmentada)
        PageSection::create([
            'section_key' => 'hero',
            'nav_label' => 'Início',
            'badge_text' => 'INTEGRESERVICE | TECNOLOGIA, GESTÃO E SAÚDE DIGITAL',
            'title' => 'Soluções inteligentes para transformar a',
            'highlighted_word' => 'gestão da sua instituição',
            'subtitle' => 'Integramos tecnologia, gestão cooperativista, telemedicina e consultoria estratégica para ajudar cooperativas, empresas e instituições a modernizar processos, ampliar o acesso aos serviços e melhorar sua eficiência operacional.',
            'description' => 'Quatro frentes de atuação. Um ecossistema de soluções para sua instituição.',
            'primary_cta_text' => 'Agende uma apresentação',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Conheça nossas soluções',
            'secondary_cta_url' => '#ecossistema',
            'palette' => 'paleta_01',
            'sort_order' => 1,
            'is_active' => true,
            'extra_data' => [
                'stat_1_value' => '4 Soluções',
                'stat_1_label' => 'Ecossistema Integrado',
                'stat_2_value' => '3 Públicos',
                'stat_2_label' => 'Cooperativas, Privado e Público',
                'stat_3_value' => '30 Dias*',
                'stat_3_label' => 'Avaliação Assistida SISCOOP3F',
                'audience_1_title' => 'Para Cooperativas',
                'audience_1_desc' => 'SISCOOP3F, organização de processos, agendamentos e rastreabilidade das operações.',
                'audience_2_title' => 'Para Saúde Privada & Empresas',
                'audience_2_desc' => 'Telemedicina 24/7, consultoria executiva, governança e eficiência operacional.',
                'audience_3_title' => 'Para Gestão Pública',
                'audience_3_desc' => 'Apoio à modernização de serviços públicos, fluxos de atendimento e saúde digital.',
            ],
        ]);

        // SEÇÃO 2: CABEÇALHO DO ECOSSISTEMA (Seção 6.2 — Quatro Soluções)
        $ecosystem = PageSection::create([
            'section_key' => 'ecosystem',
            'nav_label' => 'Nossas Soluções',
            'badge_text' => 'NOSSAS SOLUÇÕES • 4 FRENTES DE ATUAÇÃO',
            'title' => 'Tecnologia e gestão para diferentes',
            'highlighted_word' => 'necessidades institucionais',
            'subtitle' => 'Selecione abaixo uma frente de atuação para conhecer o escopo técnico, os benefícios operacionais e solicitar uma apresentação.',
            'description' => '',
            'primary_cta_text' => 'Agendar apresentação',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Conhecer o SISCOOP3F',
            'secondary_cta_url' => '#siscoop3f',
            'palette' => 'paleta_01',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $ecoItems = [
            [
                'badge' => '01 • GESTÃO COOPERATIVISTA',
                'title' => 'SISCOOP3F | Gestão Cooperativista',
                'subtitle' => 'Modernização administrativa e rastreabilidade',
                'description' => 'Uma plataforma digital para modernizar a gestão de cooperativas, organizar processos administrativos, facilitar solicitações e agendamentos e proporcionar maior rastreabilidade das operações.',
                'highlight_metric' => 'Conhecer o SISCOOP3F',
                'icon' => 'network',
                'accent_color' => 'electric',
                'link_text' => 'Conhecer o SISCOOP3F',
                'link_url' => 'https://siscoop3f.com.br/',
                'sort_order' => 1,
            ],
            [
                'badge' => '02 • SAÚDE DIGITAL',
                'title' => 'Telemedicina 24/7 | Saúde Digital',
                'subtitle' => 'Consultas por vídeo, triagem e prescrição digital',
                'description' => 'Solução de atendimento médico remoto, com consultas por vídeo, triagem e recursos de prescrição digital, conforme os serviços contratados e os protocolos assistenciais aplicáveis.',
                'highlight_metric' => 'Conhecer a Telemedicina',
                'icon' => 'video',
                'accent_color' => 'turquoise',
                'link_text' => 'Conhecer a Telemedicina',
                'link_url' => 'https://app.consulttelemedicia.com.br/login',
                'sort_order' => 2,
            ],
            [
                'badge' => '03 • GESTÃO E RESULTADOS',
                'title' => 'Consultoria Executiva | Gestão e Resultados',
                'subtitle' => 'Governança, processos e eficiência sustentável',
                'description' => 'Consultoria estratégica para organizações que buscam aprimorar seus processos, fortalecer a governança, identificar oportunidades de eficiência e desenvolver modelos sustentáveis de gestão.',
                'highlight_metric' => 'Diagnóstico Institucional',
                'icon' => 'chart-bar',
                'accent_color' => 'royal',
                'link_text' => 'Solicitar diagnóstico institucional',
                'link_url' => '#contato',
                'sort_order' => 3,
            ],
            [
                'badge' => '04 • CONHECIMENTO APLICADO',
                'title' => 'Base Científica | Conhecimento Aplicado',
                'subtitle' => 'Conteúdo técnico e científico para decisão',
                'description' => 'Conteúdo técnico e científico para apoiar o desenvolvimento profissional, a atualização de conhecimentos e a tomada de decisões fundamentadas.',
                'highlight_metric' => 'Base Científica',
                'icon' => 'book-open',
                'accent_color' => 'cyan',
                'link_text' => 'Conhecer a Base Científica',
                'link_url' => '#ecossistema',
                'sort_order' => 4,
            ],
        ];
        foreach ($ecoItems as $item) {
            $ecosystem->items()->create($item);
        }

        // ABA 01 DO ECOSSISTEMA: SISCOOP3F | Gestão Cooperativista
        $siscoop = PageSection::create([
            'section_key' => 'siscoop3f',
            'nav_label' => 'SISCOOP3F',
            'badge_text' => '01 • SISCOOP3F | GESTÃO COOPERATIVISTA',
            'title' => 'Plataforma digital para modernizar a',
            'highlighted_word' => 'gestão de cooperativas',
            'subtitle' => 'Uma plataforma digital para modernizar a gestão de cooperativas, organizar processos administrativos, facilitar solicitações e agendamentos e proporcionar maior rastreabilidade das operações.',
            'description' => 'Condições de implantação assistida e período de avaliação definidos conforme escopo operacional da cooperativa.',
            'primary_cta_text' => 'Conhecer o SISCOOP3F',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Acessar siscoop3f.com.br',
            'secondary_cta_url' => 'https://siscoop3f.com.br/',
            'palette' => 'paleta_03',
            'sort_order' => 3,
            'is_active' => true,
            'extra_data' => [
                'is_ecosystem_tab' => true,
                'tab_title' => 'SISCOOP3F',
                'tab_subtitle' => 'Gestão Cooperativista',
                'tab_icon' => 'network',
                'tab_theme' => 'light',
                'tab_type' => 'cards',
            ],
        ]);

        $siscoopItems = [
            [
                'badge' => 'COMODIDADE AO USUÁRIO',
                'title' => 'Solicitações e Agendamentos Digitais',
                'subtitle' => 'Atendimento ágil pelo celular ou web',
                'description' => 'Facilita a emissão de solicitações, guias e agendamentos online, reduzindo filas presenciais e deslocamentos físicos até a sede da cooperativa.',
                'highlight_metric' => 'Acesso Digital',
                'icon' => 'device-mobile',
                'accent_color' => 'electric',
                'sort_order' => 1,
            ],
            [
                'badge' => 'GOVERNANÇA & CONTROLE',
                'title' => 'Rastreabilidade das Operações',
                'subtitle' => 'Visibilidade gerencial para a diretoria',
                'description' => 'Organiza processos administrativos com registro de solicitações, acompanhamento de indicadores operacionais e integração aos fluxos existentes.',
                'highlight_metric' => 'Rastreabilidade',
                'icon' => 'shield-check',
                'accent_color' => 'cyan',
                'sort_order' => 2,
            ],
            [
                'badge' => 'TRANSIÇÃO PLANEJADA',
                'title' => 'Implantação Assistida e Parametrizada',
                'subtitle' => 'Acompanhamento técnico e operacional',
                'description' => 'Diagnóstico inicial, parametrização da plataforma, orientação das equipes e período inicial de avaliação assistida conforme escopo contratado.',
                'highlight_metric' => 'Implantação Segura',
                'icon' => 'clock',
                'accent_color' => 'turquoise',
                'sort_order' => 3,
            ],
        ];
        foreach ($siscoopItems as $item) {
            $siscoop->items()->create($item);
        }

        // ABA 02 DO ECOSSISTEMA: Telemedicina 24/7 | Saúde Digital
        $telemedicine = PageSection::create([
            'section_key' => 'telemedicine',
            'nav_label' => 'Telemedicina 24/7',
            'badge_text' => '02 • TELEMEDICINA 24/7 | SAÚDE DIGITAL',
            'title' => 'Atendimento médico remoto e',
            'highlighted_word' => 'organização assistencial',
            'subtitle' => 'Solução de atendimento médico remoto, com consultas por vídeo, triagem e recursos de prescrição digital, conforme os serviços contratados e os protocolos assistenciais aplicáveis. Uma alternativa para ampliar o acesso à assistência e apoiar instituições na organização de seus serviços de saúde.',
            'description' => '',
            'primary_cta_text' => 'Conhecer a Telemedicina',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Acessar Portal de Login',
            'secondary_cta_url' => 'https://app.consulttelemedicia.com.br/login',
            'palette' => 'paleta_02',
            'sort_order' => 4,
            'is_active' => true,
            'extra_data' => [
                'is_ecosystem_tab' => true,
                'tab_title' => 'Telemedicina 24/7',
                'tab_subtitle' => 'Saúde Digital',
                'tab_icon' => 'video',
                'tab_theme' => 'dark',
                'tab_type' => 'cards',
            ],
        ]);

        $teleItems = [
            [
                'badge' => 'ACESSO REMOTO',
                'title' => 'Consultas por Vídeo e Triagem Clínica',
                'subtitle' => 'Ampliação do acesso à assistência',
                'description' => 'Atendimento médico remoto estruturado conforme os serviços contratados e os protocolos assistenciais e regulatórios aplicáveis.',
                'highlight_metric' => 'Saúde Digital',
                'icon' => 'video',
                'accent_color' => 'turquoise',
                'sort_order' => 1,
            ],
            [
                'badge' => 'DOCUMENTAÇÃO CLÍNICA',
                'title' => 'Recursos de Prescrição Digital',
                'subtitle' => 'Certificação e segurança da informação',
                'description' => 'Emissão digital de documentos médicos com certificação aplicável e proteção dos dados de saúde dos usuários.',
                'highlight_metric' => 'Conformidade',
                'icon' => 'document-check',
                'accent_color' => 'cyan',
                'sort_order' => 2,
            ],
            [
                'badge' => 'ORGANIZAÇÃO DE FLUXOS',
                'title' => 'Apoio à Rede de Atendimento',
                'subtitle' => 'Orientação inicial e direcionamento',
                'description' => 'Auxilia cooperativas, empresas e instituições na organização da demanda assistencial e na redução de filas presenciais.',
                'highlight_metric' => 'Eficiência',
                'icon' => 'heart-pulse',
                'accent_color' => 'turquoise',
                'sort_order' => 3,
            ],
        ];
        foreach ($teleItems as $item) {
            $telemedicine->items()->create($item);
        }

        // ABA 03 DO ECOSSISTEMA: Consultoria Executiva | Gestão e Resultados
        $consulting = PageSection::create([
            'section_key' => 'consulting',
            'nav_label' => 'Consultoria Executiva',
            'badge_text' => '03 • CONSULTORIA EXECUTIVA | GESTÃO E RESULTADOS',
            'title' => 'Consultoria estratégica para fortalecer a',
            'highlighted_word' => 'governança e a eficiência',
            'subtitle' => 'Consultoria estratégica para organizações que buscam aprimorar seus processos, fortalecer a governança, identificar oportunidades de eficiência e desenvolver modelos sustentáveis de gestão.',
            'description' => '',
            'primary_cta_text' => 'Solicitar diagnóstico institucional',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Conhecer a Base Científica',
            'secondary_cta_url' => '#ecossistema',
            'palette' => 'paleta_01',
            'sort_order' => 5,
            'is_active' => true,
            'extra_data' => [
                'is_ecosystem_tab' => true,
                'tab_title' => 'Consultoria Executiva',
                'tab_subtitle' => 'Gestão e Resultados',
                'tab_icon' => 'chart-bar',
                'tab_theme' => 'light',
                'tab_type' => 'cards',
            ],
        ]);

        $consultingItems = [
            [
                'badge' => 'DIAGNÓSTICO & PROCESSOS',
                'title' => 'Aprimoramento de Processos Operacionais',
                'subtitle' => 'Mapeamento e eficiência administrativa',
                'description' => 'Identificação de gargalos operacionais, redesenho de fluxos internos e estruturação de indicadores de desempenho.',
                'highlight_metric' => 'Processos',
                'icon' => 'briefcase',
                'accent_color' => 'royal',
                'sort_order' => 1,
            ],
            [
                'badge' => 'GOVERNANÇA & AUDITORIA',
                'title' => 'Fortalecimento da Governança e Conformidade',
                'subtitle' => 'Transparência e análise técnica',
                'description' => 'Apoio técnico na revisão de controles internos, contratos e práticas de governança para decisões seguras.',
                'highlight_metric' => 'Governança',
                'icon' => 'shield-check',
                'accent_color' => 'cyan',
                'sort_order' => 2,
            ],
            [
                'badge' => 'DESENVOLVIMENTO ESTRATÉGICO',
                'title' => 'Mentoria e Planejamento Sustentável',
                'subtitle' => 'Apoio a diretorias e gestores',
                'description' => 'Acompanhamento estratégico para estruturação de parcerias, modernização tecnológica e sustentabilidade institucional.',
                'highlight_metric' => 'Estratégia',
                'icon' => 'academic-cap',
                'accent_color' => 'turquoise',
                'sort_order' => 3,
            ],
        ];
        foreach ($consultingItems as $item) {
            $consulting->items()->create($item);
        }

        // ABA 04 DO ECOSSISTEMA: Base Científica | Conhecimento Aplicado
        PageSection::create([
            'section_key' => 'book',
            'nav_label' => 'Base Científica',
            'badge_text' => '04 • BASE CIENTÍFICA | CONHECIMENTO APLICADO',
            'title' => 'Conteúdo técnico e científico para',
            'highlighted_word' => 'decisões fundamentadas',
            'subtitle' => 'Conteúdo técnico e científico para apoiar o desenvolvimento profissional, a atualização de conhecimentos e a tomada de decisões fundamentadas.',
            'description' => '',
            'primary_cta_text' => 'Conhecer a Base Científica',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Agendar apresentação',
            'secondary_cta_url' => '#contato',
            'palette' => 'paleta_01',
            'sort_order' => 6,
            'is_active' => true,
            'extra_data' => [
                'is_ecosystem_tab' => true,
                'tab_title' => 'Base Científica',
                'tab_subtitle' => 'Conhecimento Aplicado',
                'tab_icon' => 'book-open',
                'tab_theme' => 'dark',
                'tab_type' => 'book',
            ],
        ]);

        // SEÇÃO ESTRUTURAL: IDENTIDADE INSTITUCIONAL + LIDERANÇA (Seção 6.5 do PDF + Missão/Visão/Valores)
        PageSection::create([
            'section_key' => 'institutional_identity',
            'nav_label' => 'Quem Somos & Liderança',
            'badge_text' => 'QUEM SOMOS • IDENTIDADE E LIDERANÇA INSTITUCIONAL',
            'title' => 'A base institucional e a liderança que guiam',
            'highlighted_word' => 'nossa atuação',
            'subtitle' => 'Princípios sólidos de gestão, tecnologia, ética e cooperação voltados à modernização de instituições.',
            'description' => '',
            'primary_cta_text' => 'Falar com a direção executiva',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Conhecer modelo de implantação',
            'secondary_cta_url' => '#implantacao',
            'palette' => 'paleta_01',
            'sort_order' => 7,
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
                'leadership_badge' => 'LIDERANÇA E RELACIONAMENTO INSTITUCIONAL',
                'leadership_title' => 'Eudemir Bezerra | Direção Executiva - IntegreService',
                'leadership_bio_1' => 'À frente do relacionamento institucional e do desenvolvimento estratégico da IntegreService, Eudemir Bezerra atua na articulação de soluções e parcerias voltadas à gestão, tecnologia e inovação.',
                'leadership_bio_2' => 'Sua atuação busca aproximar instituições de ferramentas e serviços que contribuam para a modernização administrativa, a eficiência operacional e a ampliação do acesso a soluções especializadas.',
                'leadership_cta_text' => 'Falar com a direção executiva',
            ],
        ]);

        // SEÇÃO ESTRUTURAL: IMPLANTAÇÃO PLANEJADA & CONDIÇÕES COMERCIAIS (Seções 5 e 6.4 do PDF)
        $implementation = PageSection::create([
            'section_key' => 'implementation_plan',
            'nav_label' => 'Implantação e Jornada',
            'badge_text' => 'METODOLOGIA DE IMPLANTAÇÃO & JORNADA COMERCIAL',
            'title' => 'Uma implantação planejada para',
            'highlighted_word' => 'sua instituição',
            'subtitle' => 'Tecnologia com acompanhamento técnico e operacional. Nossa proposta de implantação contempla o diagnóstico das necessidades da instituição, planejamento da integração tecnológica, parametrização da solução, orientação das equipes e acompanhamento inicial.',
            'description' => 'As etapas, os prazos e as condições comerciais serão definidos conforme a solução contratada e a complexidade da operação.',
            'primary_cta_text' => 'Conheça nosso modelo de implantação',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Agendar apresentação',
            'secondary_cta_url' => '#contato',
            'palette' => 'paleta_01',
            'sort_order' => 8,
            'is_active' => true,
            'extra_data' => [
                'journey_title' => 'Jornada Comercial Recomendada em 5 Etapas',
                'commercial_note' => 'As etapas, os prazos e as condições comerciais (incluindo aplicabilidade de período de testes assistidos de 30 dias para a plataforma SISCOOP3F) serão definidos em instrumento contratual específico conforme a solução contratada e a complexidade da operação.',
            ],
        ]);

        $implementationSteps = [
            [
                'badge' => 'ETAPA 01',
                'title' => 'Agendar Apresentação',
                'subtitle' => 'Alinhamento inicial com a diretoria',
                'description' => 'Apresentamos nossas soluções, ouvimos o contexto da instituição e identificamos as prioridades imediatas.',
                'highlight_metric' => 'Passo 1',
                'icon' => 'users',
                'accent_color' => 'cyan',
                'sort_order' => 1,
            ],
            [
                'badge' => 'ETAPA 02',
                'title' => 'Diagnóstico Institucional',
                'subtitle' => 'Levantamento técnico e operacional',
                'description' => 'Avaliamos os fluxos atuais, oportunidades de modernização, integração tecnológica e requisitos específicos.',
                'highlight_metric' => 'Passo 2',
                'icon' => 'chart-bar',
                'accent_color' => 'royal',
                'sort_order' => 2,
            ],
            [
                'badge' => 'ETAPA 03',
                'title' => 'Proposta Técnica e Comercial',
                'subtitle' => 'Escopo, prazos e condições claras',
                'description' => 'Elaboramos a proposta detalhando módulos, responsabilidades técnicas, proteção de dados e modelo comercial.',
                'highlight_metric' => 'Passo 3',
                'icon' => 'document-check',
                'accent_color' => 'turquoise',
                'sort_order' => 3,
            ],
            [
                'badge' => 'ETAPA 04',
                'title' => 'Formalização e Parametrização',
                'subtitle' => 'Configuração e orientação das equipes',
                'description' => 'Formalização contratual conforme a natureza jurídica da instituição, parametrização do sistema e capacitação.',
                'highlight_metric' => 'Passo 4',
                'icon' => 'cpu',
                'accent_color' => 'electric',
                'sort_order' => 4,
            ],
            [
                'badge' => 'ETAPA 05',
                'title' => 'Operação Assistida e Indicadores',
                'subtitle' => 'Acompanhamento de resultados comprovados',
                'description' => 'Início da operação com suporte técnico, monitoramento de indicadores de eficiência e evolução contínua.',
                'highlight_metric' => 'Passo 5',
                'icon' => 'shield-check',
                'accent_color' => 'cyan',
                'sort_order' => 5,
            ],
        ];
        foreach ($implementationSteps as $step) {
            $implementation->items()->create($step);
        }

        // SEÇÃO ESTRUTURAL: SIMULADOR FINANCEIRO & PREMISSAS (Seção 6.3 do PDF)
        $investment = PageSection::create([
            'section_key' => 'investment_model',
            'nav_label' => 'Simulador Financeiro',
            'badge_text' => 'SIMULADOR DE EFICIÊNCIA & MODELO DE PARCERIA',
            'title' => 'Simule o potencial de eficiência da',
            'highlighted_word' => 'sua cooperativa',
            'subtitle' => 'Descubra oportunidades de otimização de custos e melhoria de resultados. Utilize nosso simulador para construir uma estimativa preliminar dos possíveis impactos financeiros da modernização dos processos administrativos e operacionais da sua cooperativa.',
            'description' => 'Os resultados apresentados são projeções ilustrativas e não representam garantia de economia.',
            'primary_cta_text' => 'Solicitar análise personalizada',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Agendar apresentação',
            'secondary_cta_url' => '#contato',
            'palette' => 'paleta_03',
            'sort_order' => 9,
            'is_active' => true,
            'extra_data' => [
                'simulator_title' => 'Simule o potencial de eficiência da sua cooperativa',
                'simulator_subtitle' => 'Utilize nosso simulador para construir uma estimativa preliminar dos possíveis impactos financeiros da modernização dos processos administrativos e operacionais da sua cooperativa.',
                'disclaimer_text' => 'Os resultados apresentados são projeções ilustrativas e não representam garantia de economia. A economia efetiva dependerá da estrutura atual, dos custos identificados, das soluções implantadas e dos resultados comprovados durante a operação.',
                'contract_note' => 'As condições de remuneração por desempenho serão definidas em proposta comercial e instrumento contratual específico.',
                'simulator_cta_text' => 'Solicitar análise personalizada',
            ],
        ]);

        $investmentItems = [
            [
                'badge' => 'PREMISSA 01 • EFICIÊNCIA OPERACIONAL',
                'title' => 'Retenção Estimada na Cooperativa (70%)',
                'subtitle' => 'Participação de 30% apenas sobre economia comprovada',
                'description' => 'No modelo de remuneração por desempenho do SISCOOP3F, 70% da redução de custos operacionais comprovadamente apurada permanece na cooperativa.',
                'highlight_metric' => '70% Retido',
                'icon' => 'chart-bar',
                'accent_color' => 'cyan',
                'sort_order' => 1,
            ],
            [
                'badge' => 'PREMISSA 02 • NOVAS OPORTUNIDADES',
                'title' => 'Desenvolvimento de Novas Receitas',
                'subtitle' => 'Participação vinculada a resultados efetivos',
                'description' => 'Estruturação consultiva de novas oportunidades de serviço para a cooperativa, com participação de 30% apenas sobre receitas efetivamente geradas.',
                'highlight_metric' => 'Sob Resultado',
                'icon' => 'trending-up',
                'accent_color' => 'turquoise',
                'sort_order' => 2,
            ],
            [
                'badge' => 'PREMISSA 03 • DESCONTO AO USUÁRIO',
                'title' => 'Tarifa de Parceria para Acesso Digital',
                'subtitle' => 'De R$ 20,00 por R$ 10,00 por usuário/mês',
                'description' => 'Redução de 50% na tarifa referencial de comodidade digital para emissão de guias e agendamentos pelos usuários vinculados.',
                'highlight_metric' => 'R$ 10/usuário',
                'icon' => 'sparkles',
                'accent_color' => 'electric',
                'sort_order' => 3,
            ],
        ];
        foreach ($investmentItems as $item) {
            $investment->items()->create($item);
        }

        // SEÇÃO ESTRUTURAL: SOLUÇÕES PARA A GESTÃO PÚBLICA (Seção 6.6 do PDF)
        $publicManagement = PageSection::create([
            'section_key' => 'public_management',
            'nav_label' => 'Gestão Pública',
            'badge_text' => 'SETOR PÚBLICO & MUNICÍPIOS • CONFORMIDADE E EFICIÊNCIA',
            'title' => 'Soluções para a Gestão Pública: Tecnologia para apoiar a',
            'highlighted_word' => 'modernização dos serviços públicos',
            'subtitle' => 'A IntegreService desenvolve propostas de soluções tecnológicas e serviços especializados que podem apoiar municípios e instituições públicas na organização de processos, na gestão de informações e na ampliação do acesso à saúde digital.',
            'description' => 'Cada projeto é estruturado conforme as necessidades do órgão, a viabilidade técnica, os requisitos regulatórios e as normas de contratação pública aplicáveis.',
            'primary_cta_text' => 'Solicitar apresentação para gestão pública',
            'primary_cta_url' => '#contato',
            'secondary_cta_text' => 'Solicitar diagnóstico técnico',
            'secondary_cta_url' => '#contato',
            'palette' => 'paleta_01',
            'sort_order' => 10,
            'is_active' => true,
            'extra_data' => [
                'regulatory_note' => 'Cada projeto é estruturado conforme as necessidades do órgão, a viabilidade técnica, os requisitos regulatórios, a proteção de dados (LGPD) e as normas de contratação pública aplicáveis.',
            ],
        ]);

        $publicItems = [
            [
                'badge' => 'APLICAÇÃO 01 • SAÚDE DIGITAL',
                'title' => 'Apoio à Estruturação de Telemedicina',
                'subtitle' => 'Ampliação do acesso assistencial no município',
                'description' => 'Estruturação de atendimento médico remoto e triagem digital conforme protocolos assistenciais e necessidades da rede pública.',
                'highlight_metric' => 'Saúde Pública',
                'icon' => 'video',
                'accent_color' => 'turquoise',
                'sort_order' => 1,
            ],
            [
                'badge' => 'APLICAÇÃO 02 • FLUXOS DIGITAIS',
                'title' => 'Integração de Ferramentas ao Atendimento',
                'subtitle' => 'Agendamentos e organização da demanda',
                'description' => 'Implantação de ferramentas digitais para organizar filas, solicitações e fluxos de atendimento ao cidadão.',
                'highlight_metric' => 'Atendimento',
                'icon' => 'network',
                'accent_color' => 'cyan',
                'sort_order' => 2,
            ],
            [
                'badge' => 'APLICAÇÃO 03 • GESTÃO ADMINISTRATIVA',
                'title' => 'Organização de Processos e Informações',
                'subtitle' => 'Padronização e rastreabilidade documental',
                'description' => 'Modernização de rotinas administrativas para elevar a eficiência operacional e a transparência dos registros.',
                'highlight_metric' => 'Processos',
                'icon' => 'document-check',
                'accent_color' => 'royal',
                'sort_order' => 3,
            ],
            [
                'badge' => 'APLICAÇÃO 04 • MONITORAMENTO',
                'title' => 'Acompanhamento de Indicadores',
                'subtitle' => 'Painéis gerenciais para tomada de decisão',
                'description' => 'Consolidação de indicadores operacionais e assistenciais para apoiar secretarias e gestores públicos.',
                'highlight_metric' => 'Indicadores',
                'icon' => 'chart-bar',
                'accent_color' => 'electric',
                'sort_order' => 4,
            ],
            [
                'badge' => 'APLICAÇÃO 05 • PLANEJAMENTO',
                'title' => 'Consultoria para Diagnóstico e Planejamento',
                'subtitle' => 'Estudos técnicos e modelagem de projetos',
                'description' => 'Apoio técnico especializado para diagnóstico situacional, planejamento estratégico e modernização institucional.',
                'highlight_metric' => 'Planejamento',
                'icon' => 'briefcase',
                'accent_color' => 'cyan',
                'sort_order' => 5,
            ],
        ];
        foreach ($publicItems as $item) {
            $publicManagement->items()->create($item);
        }

        // SEÇÃO ESTRUTURAL: CONTATO & AGENDAMENTO DE APRESENTAÇÃO (Seções 6.7 e 6.8 do PDF)
        PageSection::create([
            'section_key' => 'contact',
            'nav_label' => 'Contato',
            'badge_text' => 'ATENDIMENTO COMERCIAL & AGENDAMENTO DE APRESENTAÇÃO',
            'title' => 'Vamos conhecer as necessidades da',
            'highlighted_word' => 'sua instituição?',
            'subtitle' => 'Agende uma apresentação com nossa equipe. Apresentamos nossas soluções, entendemos os desafios da sua operação e identificamos oportunidades de modernização, integração tecnológica e melhoria de processos. Nossa equipe poderá elaborar uma proposta técnica e comercial de acordo com o perfil da sua instituição.',
            'description' => '',
            'primary_cta_text' => 'Agendar apresentação',
            'primary_cta_url' => '#form-proposta',
            'secondary_cta_text' => 'Solicitar diagnóstico',
            'secondary_cta_url' => '#whatsapp',
            'palette' => 'paleta_01',
            'sort_order' => 11,
            'is_active' => true,
        ]);

        // 3. Limpa registros antigos de departamentos de clínica
        ClinicDepartment::query()->delete();

        // 4. Publicações & Base Científica (Seção 6.2 - 04)
        Publication::query()->delete();
        $publications = [
            [
                'title' => 'Gestão Integrada, Saúde & Cooperativismo: Conhecimento Aplicado à Eficiência Institucional',
                'subtitle' => 'Base científica e metodológica para modernização administrativa e tomada de decisões fundamentadas',
                'category' => 'Base Científica',
                'author' => 'Eudemir Bezerra',
                'year' => '2026',
                'summary' => 'Conteúdo técnico e científico desenvolvido para apoiar gestores, dirigentes de cooperativas e lideranças institucionais no aprimoramento de processos, fortalecimento da governança e adoção planejada de tecnologias.',
                'content' => '',
                'highlights' => [
                    'Organização de processos administrativos e rastreabilidade operacional',
                    'Modelos de governança e indicadores de eficiência para instituições',
                    'Integração de saúde digital e telemedicina com protocolos seguros',
                    'Planejamento técnico para modernização de cooperativas e serviços',
                ],
                'cta_text' => 'Conhecer a Base Científica',
                'cta_url' => '#contato',
                'is_featured_book' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Modernização de Processos em Cooperativas: Diagnóstico e Implantação Assistida',
                'subtitle' => 'Caderno Técnico de Gestão e Operações',
                'category' => 'Estudo Técnico',
                'author' => 'Eudemir Bezerra',
                'year' => '2026',
                'summary' => 'Diretrizes práticas para transição tecnológica segura, parametrização de fluxos digitais e acompanhamento de resultados operacionais.',
                'highlights' => [
                    'Metodologia de diagnóstico institucional prévio',
                    'Indicadores auditáveis de eficiência e atendimento',
                ],
                'cta_text' => 'Solicitar Apresentação',
                'cta_url' => '#contato',
                'is_featured_book' => false,
                'sort_order' => 2,
                'is_active' => true,
            ],
        ];
        foreach ($publications as $pub) {
            Publication::create($pub);
        }

        // 5. Lead Inicial de Exemplo no CRM
        Lead::query()->delete();
        Lead::create([
            'name' => 'Alan Nogueira',
            'organization' => 'CBSAÚDE - Cooperativa de Saúde',
            'role' => 'Diretoria Executiva',
            'email' => 'contato@cbsaude.com.br',
            'phone' => '(68) 99999-1111',
            'vertical_interest' => 'Gestão Cooperativista - SISCOOP3F',
            'estimated_users' => 1500,
            'message' => 'Solicitação de apresentação técnica e diagnóstico institucional referente à plataforma SISCOOP3F.',
            'status' => 'proposta_enviada',
            'admin_notes' => 'Atendimento institucional conduzido em Rio Branco - Acre por Eudemir Bezerra.',
        ]);
    }
}
