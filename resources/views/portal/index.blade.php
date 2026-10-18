@php
    $seoTitle = $settings->seo_title ?: ($settings->brand_part_1 . $settings->brand_part_2 . ' — ' . $settings->brand_tagline);
    $seoDescription = $settings->seo_description ?: ($settings->footer_description ?: 'IntegreService: Rede integrada de gestão cooperativista digital (SISCOOP3F), Telemedicina 24/7, Consultoria Executiva e Base Científica.');
    $seoKeywords = $settings->seo_keywords ?: 'IntegreService, SISCOOP3F, gestão de cooperativas, cooperativa de saúde, telemedicina 24h, consultoria executiva, auditoria, mentoria, Eudemir Bezerra, Rio Branco Acre';
    $canonicalUrl = rtrim(url('/'), '/') . '/';
    $ogImageUrl = asset($settings->og_image_path ?: $settings->logo_path);
    $logoUrl = asset($settings->logo_path);
    $identitySection = $sections['institutional_identity'] ?? null;
    $identityExtra = $identitySection?->extra_data ?? [];

    $jsonLdGraph = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => ['Organization', 'ProfessionalService'],
                '@id' => $canonicalUrl . '#organization',
                'name' => $settings->brand_part_1 . $settings->brand_part_2,
                'alternateName' => 'IntegreService (IS) — ' . $settings->brand_tagline,
                'url' => $canonicalUrl,
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => $logoUrl,
                ],
                'image' => $ogImageUrl,
                'description' => $seoDescription,
                'slogan' => $identityExtra['purpose_text'] ?? $settings->brand_tagline,
                'email' => $settings->contact_email,
                'telephone' => $settings->contact_phone,
                'founder' => [
                    '@type' => 'Person',
                    'name' => $settings->consultant_name,
                    'jobTitle' => $settings->consultant_role,
                ],
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Rio Branco',
                    'addressRegion' => 'AC',
                    'addressCountry' => 'BR',
                ],
                'areaServed' => [
                    '@type' => 'Country',
                    'name' => 'Brasil',
                ],
                'sameAs' => array_values(array_filter([
                    $settings->siscoop3f_url,
                    $settings->telemedicine_url,
                ])),
            ],
            [
                '@type' => 'WebSite',
                '@id' => $canonicalUrl . '#website',
                'url' => $canonicalUrl,
                'name' => $seoTitle,
                'description' => $seoDescription,
                'inLanguage' => 'pt-BR',
                'publisher' => [
                    '@id' => $canonicalUrl . '#organization',
                ],
            ],
            [
                '@type' => 'SoftwareApplication',
                'name' => 'SISCOOP3F — Gestão Cooperativista Integrada',
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem' => 'Web, Android, iOS',
                'url' => $settings->siscoop3f_url,
                'description' => 'Plataforma digital para gestão de cooperativas, emissão de guias pelo celular, agendamentos e rastreabilidade em tempo real com ' . ($settings->sim_trial_days ?? 30) . ' dias de implantação gratuita.',
                'offers' => [
                    '@type' => 'Offer',
                    'price' => '0.00',
                    'priceCurrency' => 'BRL',
                    'description' => ($settings->sim_trial_days ?? 30) . ' dias de implantação assistida sem custo inicial.',
                ],
                'provider' => [
                    '@id' => $canonicalUrl . '#organization',
                ],
            ],
        ],
    ];

    if (!empty($featuredBook)) {
        $jsonLdGraph['@graph'][] = [
            '@type' => 'Book',
            'name' => $featuredBook->title,
            'alternativeHeadline' => $featuredBook->subtitle,
            'author' => [
                '@type' => 'Person',
                'name' => $featuredBook->author,
            ],
            'datePublished' => (string) $featuredBook->year,
            'inLanguage' => 'pt-BR',
            'abstract' => $featuredBook->summary,
            'publisher' => [
                '@id' => $canonicalUrl . '#organization',
            ],
        ];
    }
@endphp
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- 1. SEO Primário & Indexação Google -->
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="{{ $seoKeywords }}">
    <meta name="author" content="{{ $settings->consultant_name }} — {{ $settings->brand_part_1 }}{{ $settings->brand_part_2 }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="googlebot" content="index, follow">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- 2. Geolocalização & Identidade Regional (Acre / Brasil) -->
    <meta name="geo.region" content="BR-AC">
    <meta name="geo.placename" content="{{ $settings->company_city }}">
    <meta name="theme-color" content="#011328">
    <meta name="format-detection" content="telephone=no">

    @if(!empty($settings->google_verification_code))
        <meta name="google-site-verification" content="{{ $settings->google_verification_code }}">
    @endif

    <!-- 3. Open Graph (WhatsApp, LinkedIn, Facebook, Instagram) -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:site_name" content="{{ $settings->brand_part_1 }}{{ $settings->brand_part_2 }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $ogImageUrl }}">
    <meta property="og:image:alt" content="{{ $settings->brand_part_1 }}{{ $settings->brand_part_2 }} — {{ $settings->brand_tagline }}">

    <!-- 4. Twitter / X Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $ogImageUrl }}">

    <!-- 5. Ícones & Sitemap -->
    <link rel="icon" type="image/png" href="{{ $logoUrl }}">
    <link rel="apple-touch-icon" href="{{ $logoUrl }}">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('portal.sitemap') }}">

    <!-- 6. Dados Estruturados Schema.org (JSON-LD para Rich Snippets no Google) -->
    <script type="application/ld+json">{!! json_encode($jsonLdGraph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

    @if(!empty($settings->google_analytics_id))
        <!-- Google Analytics (GA4) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $settings->google_analytics_id }}');
        </script>
    @endif

    <!-- Google Fonts Oficiais: Montserrat e Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vite Bundle: Tailwind CSS v4 + Vue.js 3.5+ -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        window.__INTEGRESERVICE_STATE__ = @json($vueState);
    </script>
</head>
<body class="antialiased selection:bg-[#00B4D8] selection:text-white">
    <div id="integreservice-portal-app">
        <!-- Pré-Renderização Semântica Completa (SSR SEO Fallback para Googlebot, Leitores de Tela e Testes) -->
        <main class="sr-only">
            <header>
                <h1>{{ $settings->brand_part_1 }}{{ $settings->brand_part_2 }} — {{ $settings->brand_tagline }}</h1>
                <p>{{ $seoDescription }}</p>
                <p>Consultor e Representante Oficial: {{ $settings->consultant_name }} ({{ $settings->consultant_role }}) — {{ $settings->company_city }}</p>
                <nav aria-label="Links Principais">
                    <a href="{{ $settings->siscoop3f_url }}">Plataforma SISCOOP3F — Gestão Cooperativista</a>
                    <a href="{{ $settings->telemedicine_url }}">Portal de Telemedicina 24/7</a>
                </nav>
            </header>

            @foreach($sections as $sec)
                <section id="ssr-{{ $sec->section_key }}">
                    <h2>{{ $sec->badge_text }} — {{ $sec->title }} {{ $sec->highlighted_word }}</h2>
                    @if($sec->subtitle)
                        <p>{{ $sec->subtitle }}</p>
                    @endif
                    @if($sec->description)
                        <p>{{ $sec->description }}</p>
                    @endif

                    @if($sec->section_key === 'institutional_identity' && is_array($sec->extra_data))
                        <article>
                            <h3>{{ $sec->extra_data['purpose_label'] ?? 'Razão de Existir' }}</h3>
                            <p>{{ $sec->extra_data['purpose_text'] ?? '' }}</p>
                        </article>
                        <article>
                            <h3>{{ $sec->extra_data['mission_label'] ?? 'Missão' }}</h3>
                            <p>{{ $sec->extra_data['mission_text'] ?? '' }}</p>
                        </article>
                        <article>
                            <h3>{{ $sec->extra_data['vision_label'] ?? 'Visão' }}</h3>
                            <p>{{ $sec->extra_data['vision_text'] ?? '' }}</p>
                        </article>
                        <article>
                            <h3>{{ $sec->extra_data['values_label'] ?? 'Valores Institucionais' }}</h3>
                            <p>{{ $sec->extra_data['values_text'] ?? '' }}</p>
                        </article>
                    @endif

                    @if($sec->activeItems && $sec->activeItems->count())
                        <ul>
                            @foreach($sec->activeItems as $item)
                                <li>
                                    <strong>{{ $item->title }}</strong>
                                    @if($item->highlight_metric) ({{ $item->highlight_metric }}) @endif
                                    — {{ $item->description }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </section>
            @endforeach

            @if($featuredBook)
                <section id="ssr-featured-book">
                    <h2>{{ $featuredBook->category }}: {{ $featuredBook->title }} ({{ $featuredBook->year }})</h2>
                    <p>Autor: {{ $featuredBook->author }}</p>
                    <p>{{ $featuredBook->summary }}</p>
                </section>
            @endif
        </main>
    </div>
</body>
</html>
