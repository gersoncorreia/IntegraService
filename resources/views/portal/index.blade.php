<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->brand_part_1 }}{{ $settings->brand_part_2 }} — {{ $settings->brand_tagline }}</title>
    <meta name="description" content="{{ $settings->footer_description }}">

    <!-- Favicon Oficial -->
    <link rel="icon" type="image/png" href="{{ asset($settings->logo_path) }}">

    <!-- Google Fonts Oficiais (Manual Seção 6.1): Montserrat e Inter -->
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
        <!-- Fallback / Pre-hydration SSR Content para SEO e Testes Automatizados -->
        <div class="sr-only">
            <h1>{{ $settings->brand_part_1 }}{{ $settings->brand_part_2 }} — {{ $settings->brand_tagline }}</h1>
            <p>Consultor: {{ $settings->consultant_name }}</p>
            <a href="{{ $settings->siscoop3f_url }}">SISCOOP3F</a>
            <a href="{{ $settings->telemedicine_url }}">Telemedicina</a>
            @foreach($sections as $sec)
                <h2>{{ $sec->badge_text }} - {{ $sec->title }} {{ $sec->highlighted_word }}</h2>
                <p>{{ $sec->subtitle }}</p>
            @endforeach
        </div>
    </div>
</body>
</html>
