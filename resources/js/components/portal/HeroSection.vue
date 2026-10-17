<script setup>
import BrandLogo from '../ui/BrandLogo.vue';
import AppIcon from '../ui/AppIcon.vue';

defineProps({
    hero: { type: Object, required: true },
    settings: { type: Object, required: true },
});
</script>

<template>
    <section
        id="inicio"
        class="relative overflow-hidden section-dark-hero text-white py-12 sm:py-20 lg:py-28 border-b border-cyan-500/20"
    >
        <!-- Iluminação Atmosférica Controlada -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-40 -left-40 w-[520px] h-[520px] rounded-full bg-[#00509D]/30 blur-[150px]"></div>
            <div class="absolute bottom-0 right-0 w-[480px] h-[480px] rounded-full bg-[#00B4D8]/15 blur-[140px]"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">
            <div class="grid lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                <!-- Coluna Esquerda: Autoridade Editorial com Entrada Escalonada Suave (7 Colunas) -->
                <div class="lg:col-span-7 space-y-5 sm:space-y-7">
                    <!-- Passo 1 da Coreografia: Kicker Editorial -->
                    <div class="hero-stagger-1 inline-flex items-center gap-2.5 sm:gap-3 pl-2.5 sm:pl-3 pr-3 sm:pr-4 py-1.5 bg-white/[0.06] border-l-2 border-[#00E5FF] border-y border-r border-y-white/10 border-r-white/10 rounded-r max-w-full">
                        <span class="w-2 h-2 rounded-xs bg-[#00E5FF] animate-pulse-ring shrink-0"></span>
                        <span class="font-brand text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.11em] sm:tracking-[0.14em] text-cyan-200 leading-snug">
                            {{ hero.badge_text }}
                        </span>
                    </div>

                    <!-- Passo 2 da Coreografia: Título Principal -->
                    <h1 class="hero-stagger-2 font-brand text-[28px] sm:text-5xl lg:text-[52px] font-extrabold leading-[1.12] sm:leading-[1.1] tracking-[-0.025em]">
                        {{ hero.title }}
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00E5FF] via-[#48BFE3] to-[#80FFDB]">
                            {{ hero.highlighted_word }}
                        </span>
                    </h1>

                    <!-- Passo 3 da Coreografia: Subtítulo -->
                    <p class="hero-stagger-3 text-sm sm:text-lg text-slate-200/95 leading-relaxed max-w-xl font-normal">
                        {{ hero.subtitle }}
                    </p>

                    <!-- Passo 4 da Coreografia: Botões Executivos (Full-width no celular para fácil toque com o polegar) -->
                    <div class="hero-stagger-4 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4 pt-1">
                        <a
                            :href="hero.primary_cta_url || '#contato'"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-6 sm:px-7 py-4 rounded-md font-brand font-bold text-xs uppercase tracking-[0.1em] text-[#01162E] bg-[#00E5FF] hover:bg-[#80FFDB] shadow-[0_8px_24px_rgba(0,229,255,0.28)] hover:-translate-y-0.5 transition-all duration-300 text-center"
                        >
                            <span>{{ hero.primary_cta_text }}</span>
                            <span class="text-sm font-black">→</span>
                        </a>

                        <a
                            :href="hero.secondary_cta_url || '#ecossistema'"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 sm:py-4 rounded-md font-brand font-semibold text-xs uppercase tracking-[0.08em] text-white bg-white/[0.06] hover:bg-white/[0.12] border border-white/20 transition-all duration-300 text-center"
                        >
                            <span>{{ hero.secondary_cta_text }}</span>
                        </a>
                    </div>

                    <!-- Passo 5 da Coreografia: Barra de Indicadores Estruturada (Otimizada para 360px sem quebrar linha!) -->
                    <div class="hero-stagger-5 grid grid-cols-3 divide-x divide-white/15 pt-5 sm:pt-7 border-t border-white/15 max-w-xl">
                        <div class="pr-2.5 sm:pr-6">
                            <div class="font-brand text-lg sm:text-3xl font-extrabold text-[#00E5FF] tracking-tight whitespace-nowrap">
                                {{ hero.extra_data?.stat_1_value || '5 Soluções' }}
                            </div>
                            <div class="text-[11px] sm:text-xs text-slate-300 mt-0.5 sm:mt-1 font-medium leading-tight">
                                {{ hero.extra_data?.stat_1_label || 'Integradas em Rede' }}
                            </div>
                        </div>
                        <div class="px-2.5 sm:px-6">
                            <div class="font-brand text-lg sm:text-3xl font-extrabold text-[#80FFDB] tracking-tight whitespace-nowrap">
                                {{ hero.extra_data?.stat_2_value || '30 Dias' }}
                            </div>
                            <div class="text-[11px] sm:text-xs text-slate-300 mt-0.5 sm:mt-1 font-medium leading-tight">
                                {{ hero.extra_data?.stat_2_label || 'Implantação Gratuita' }}
                            </div>
                        </div>
                        <div class="pl-2.5 sm:pl-6">
                            <div class="font-brand text-lg sm:text-3xl font-extrabold text-white tracking-tight whitespace-nowrap">
                                {{ hero.extra_data?.stat_3_value || 'R$ 0,00' }}
                            </div>
                            <div class="text-[11px] sm:text-xs text-slate-300 mt-0.5 sm:mt-1 font-medium leading-tight">
                                {{ hero.extra_data?.stat_3_label || 'Desembolso Inicial' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coluna Direita: Console de Acesso Operacional com Fade Lateral Suave (5 Colunas) -->
                <div class="lg:col-span-5 hero-console-reveal">
                    <div class="rounded-lg bg-[#011328]/90 border border-white/15 shadow-[0_24px_60px_rgba(0,0,0,0.45)] overflow-hidden animate-float-subtle">
                        <!-- Linha Superior Técnica -->
                        <div class="h-1 w-full bg-gradient-to-r from-[#00509D] via-[#00E5FF] to-[#80FFDB]"></div>

                        <div class="p-5 sm:p-7 space-y-5 sm:space-y-6">
                            <!-- Cabeçalho do Console -->
                            <div class="flex items-center justify-between gap-2 pb-4 sm:pb-5 border-b border-white/10">
                                <BrandLogo
                                    :part1="settings.brand_part_1"
                                    :part2="settings.brand_part_2"
                                    :tagline="settings.brand_tagline"
                                    :logoPath="settings.logo_path"
                                    theme="dark"
                                    size="sm"
                                    href="#ecossistema"
                                />
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-[10px] font-brand font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-300 border border-emerald-500/30 shrink-0">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    Online
                                </span>
                            </div>

                            <!-- Lista de Plataformas Responsiva (Sem espremer o texto em celulares estreitos!) -->
                            <div class="space-y-3">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-[10px] sm:text-[11px] uppercase font-brand font-bold tracking-[0.12em] sm:tracking-[0.14em] text-cyan-300">
                                        Ambientes Digitais Ativos
                                    </span>
                                    <span class="text-[10px] font-mono text-slate-400 shrink-0">SSL • 24/7</span>
                                </div>

                                <!-- Card 1: SISCOOP3F -->
                                <a
                                    :href="settings.siscoop3f_url"
                                    target="_blank"
                                    rel="noopener"
                                    class="group block p-4 sm:p-5 rounded-md bg-[#022347]/80 hover:bg-[#032E5C] border border-white/10 hover:border-[#80FFDB]/60 border-l-4 border-l-[#80FFDB] transition-all duration-300"
                                >
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3 min-w-0">
                                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded bg-[#80FFDB]/15 border border-[#80FFDB]/30 flex items-center justify-center text-[#80FFDB] shrink-0 mt-0.5">
                                                <AppIcon name="network" class="w-4 h-4 sm:w-5 sm:h-5" />
                                            </div>
                                            <div class="min-w-0">
                                                <span class="font-brand font-bold text-white text-sm sm:text-base tracking-tight block">
                                                    Portal SISCOOP3F
                                                </span>
                                                <p class="text-xs text-slate-300 mt-0.5 leading-relaxed">
                                                    Gestão cooperativista, guias e agendamentos digitais
                                                </p>
                                            </div>
                                        </div>

                                        <span class="inline-flex items-center gap-1 px-2.5 sm:px-3.5 py-1.5 sm:py-2 rounded bg-[#80FFDB]/15 group-hover:bg-[#80FFDB] text-[#80FFDB] group-hover:text-[#01162E] font-brand font-bold text-[11px] sm:text-xs whitespace-nowrap shrink-0 transition-all duration-300">
                                            <span>Acessar</span>
                                            <span>↗</span>
                                        </span>
                                    </div>
                                </a>

                                <!-- Card 2: Telemedicina -->
                                <a
                                    :href="settings.telemedicine_url"
                                    target="_blank"
                                    rel="noopener"
                                    class="group block p-4 sm:p-5 rounded-md bg-[#021C3B]/90 hover:bg-[#032854] border border-white/10 hover:border-[#00F5D4]/60 border-l-4 border-l-[#00F5D4] transition-all duration-300"
                                >
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3 min-w-0">
                                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded bg-[#00F5D4]/15 border border-[#00F5D4]/30 flex items-center justify-center text-[#00F5D4] shrink-0 mt-0.5">
                                                <AppIcon name="video" class="w-4 h-4 sm:w-5 sm:h-5" />
                                            </div>
                                            <div class="min-w-0">
                                                <span class="font-brand font-bold text-white text-sm sm:text-base tracking-tight block">
                                                    Telemedicina 24/7
                                                </span>
                                                <p class="text-xs text-slate-300 mt-0.5 leading-relaxed">
                                                    Consultas por vídeo, triagem e prescrição digital
                                                </p>
                                            </div>
                                        </div>

                                        <span class="inline-flex items-center gap-1 px-2.5 sm:px-3.5 py-1.5 sm:py-2 rounded bg-[#00F5D4]/15 group-hover:bg-[#00F5D4] text-[#00F5D4] group-hover:text-[#01162E] font-brand font-bold text-[11px] sm:text-xs whitespace-nowrap shrink-0 transition-all duration-300">
                                            <span>Login</span>
                                            <span>↗</span>
                                        </span>
                                    </div>
                                </a>
                            </div>

                            <!-- Rodapé Técnico do Console -->
                            <div class="pt-3.5 sm:pt-4 border-t border-white/10 flex flex-wrap items-center justify-between gap-2 text-[11px] sm:text-xs text-slate-300">
                                <span>Direção Executiva: <strong class="text-white font-semibold">{{ settings.consultant_name }}</strong></span>
                                <span class="text-cyan-300 font-medium">{{ settings.company_city }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
