@props([
    'part1' => 'Integre',
    'part2' => 'Service',
    'tagline' => 'Rede de Serviços & Tecnologia',
    'logoPath' => '/assets/images/logo-icon.png',
    'theme' => 'light', // light, dark, turquoise, electric
    'size' => 'md', // sm, md, lg
    'href' => '/',
])

@php
    $iconSizes = [
        'sm' => 'h-10',
        'md' => 'h-12 md:h-13',
        'lg' => 'h-16 md:h-20',
    ];
    $titleSizes = [
        'sm' => 'text-xl',
        'md' => 'text-2xl md:text-[28px]',
        'lg' => 'text-3xl md:text-4xl',
    ];
    $taglineSizes = [
        'sm' => 'text-[9.5px]',
        'md' => 'text-[10.5px] md:text-[11.5px]',
        'lg' => 'text-xs md:text-sm',
    ];

    $part1Colors = [
        'light' => 'text-[#022B5B]',
        'dark' => 'text-white',
        'turquoise' => 'text-[#03045E]',
        'electric' => 'text-white',
    ];
    $part2Colors = [
        'light' => 'text-[#00B4D8]',
        'dark' => 'text-[#00E5FF]',
        'turquoise' => 'text-[#00BBF9]',
        'electric' => 'text-[#48BFE3]',
    ];
    $taglineColors = [
        'light' => 'text-[#0077B6]',
        'dark' => 'text-[#A0E9FF]',
        'turquoise' => 'text-[#0077B6]',
        'electric' => 'text-[#80FFDB]',
    ];
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-3.5 group select-none text-decoration-none']) }} aria-label="{{ $part1 }}{{ $part2 }} - {{ $tagline }}">
    <div class="relative flex items-center justify-center shrink-0">
        <!-- Núcleo de Energia Glow Sutil no Ícone -->
        <span class="absolute -inset-1.5 rounded-full bg-gradient-to-tr from-[#00509D]/25 via-[#00B4D8]/30 to-[#00E5FF]/40 blur-md opacity-75 group-hover:opacity-100 group-hover:scale-110 transition-all duration-500"></span>
        <img
            src="{{ asset($logoPath) }}"
            alt="Ícone {{ $part1 }}{{ $part2 }}"
            class="{{ $iconSizes[$size] ?? $iconSizes['md'] }} w-auto object-contain relative z-10 drop-shadow-[0_2px_10px_rgba(0,180,216,0.28)] transition-transform duration-500 group-hover:scale-105"
        />
    </div>
    <div class="flex flex-col justify-center leading-[1.08]">
        <div class="font-brand {{ $titleSizes[$size] ?? $titleSizes['md'] }} tracking-[-0.02em] m-0 flex items-baseline">
            <span class="font-extrabold {{ $part1Colors[$theme] ?? $part1Colors['light'] }} transition-colors duration-300">{{ $part1 }}</span><span class="font-medium {{ $part2Colors[$theme] ?? $part2Colors['light'] }} tracking-[-0.01em] transition-colors duration-300">{{ $part2 }}</span>
        </div>
        <span class="font-brand {{ $taglineSizes[$size] ?? $taglineSizes['md'] }} font-semibold {{ $taglineColors[$theme] ?? $taglineColors['light'] }} tracking-[0.09em] uppercase mt-1 transition-all duration-300">
            {{ $tagline }}
        </span>
    </div>
</a>
