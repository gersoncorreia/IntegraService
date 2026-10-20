<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import BrandLogo from '../ui/BrandLogo.vue';

defineProps({
    settings: { type: Object, required: true },
    urls: { type: Object, required: true },
    ecosystemTabs: { type: Array, default: () => [] },
    isAuthenticated: { type: Boolean, default: false },
});

const emit = defineEmits(['open-platforms', 'navigate-tab']);

const scrolled = ref(false);
const mobileMenuOpen = ref(false);

const handleScroll = () => {
    scrolled.value = window.scrollY > 16;
};

const selectTabAndScroll = (tabKey) => {
    mobileMenuOpen.value = false;
    emit('navigate-tab', tabKey);
    const el = document.getElementById('ecossistema');
    if (el) el.scrollIntoView({ behavior: 'smooth' });
};

onMounted(() => window.addEventListener('scroll', handleScroll, { passive: true }));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>

<template>
    <header
        :class="[
            'sticky top-0 z-40 w-full transition-all duration-300',
            scrolled
                ? 'bg-white/95 backdrop-blur-md shadow-[0_4px_24px_rgba(2,43,91,0.06)] border-b border-slate-200 py-2.5'
                : 'bg-white border-b border-slate-200/80 py-2.5 sm:py-3'
        ]"
    >
        <!-- Barra Superior de Edição Rápida (Exibida quando o Admin está logado!) -->
        <div
            v-if="isAuthenticated"
            class="bg-[#011328] text-white border-b border-cyan-500/30 py-1.5 px-4 text-xs"
        >
            <div class="max-w-6xl mx-auto flex flex-wrap items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#00E5FF]"></span>
                    <span class="font-brand font-bold text-[11px] uppercase tracking-wider text-cyan-200">
                        Modo Administrador Ativo
                    </span>
                </div>
                <div class="flex items-center gap-3">
                    <a :href="urls.adminSections || urls.adminDashboard" class="font-brand font-bold text-[11px] text-[#00E5FF] hover:underline">
                        Gerenciar Frentes de Atuação & Seções →
                    </a>
                    <a :href="urls.adminDashboard" class="px-2.5 py-0.5 rounded bg-white/10 hover:bg-white/20 font-brand font-bold text-[11px] text-white">
                        Abrir Painel CMS
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between gap-2 sm:gap-4">
            <!-- Logo Oficial Responsiva -->
            <BrandLogo
                :part1="settings.brand_part_1"
                :part2="settings.brand_part_2"
                :tagline="settings.brand_tagline"
                :logoPath="settings.logo_path"
                theme="light"
                size="sm"
                href="#inicio"
            />

            <!-- Navegação Central Executiva (Desktop) -->
            <nav class="hidden lg:flex items-center gap-0.5">
                <a
                    href="#ecossistema"
                    class="px-3 py-2 rounded text-[13px] font-brand font-semibold text-[#022B5B] hover:text-[#00509D] hover:bg-slate-100/80 transition whitespace-nowrap"
                >
                    Soluções
                </a>
                <a
                    href="#identidade"
                    class="px-3 py-2 rounded text-[13px] font-brand font-semibold text-[#022B5B] hover:text-[#00509D] hover:bg-slate-100/80 transition whitespace-nowrap"
                >
                    Sobre nós
                </a>
                <a
                    href="#siscoop3f"
                    class="px-3 py-2 rounded text-[13px] font-brand font-semibold text-[#022B5B] hover:text-[#00509D] hover:bg-slate-100/80 transition inline-flex items-center gap-1.5 whitespace-nowrap"
                >
                    <span>SISCOOP3F</span>
                    <span class="px-1.5 py-0.5 text-[10px] font-extrabold tracking-wider uppercase rounded-xs bg-[#022B5B] text-[#00E5FF]">
                        Simulador
                    </span>
                </a>
                <a
                    href="#gestao-publica"
                    class="px-3 py-2 rounded text-[13px] font-brand font-semibold text-[#022B5B] hover:text-[#00509D] hover:bg-slate-100/80 transition whitespace-nowrap"
                >
                    Gestão Pública
                </a>
                <button
                    type="button"
                    @click="selectTabAndScroll('telemedicine')"
                    class="px-3 py-2 rounded text-[13px] font-brand font-semibold text-[#022B5B] hover:text-[#00509D] hover:bg-slate-100/80 transition whitespace-nowrap cursor-pointer"
                >
                    Telemedicina
                </button>
                <a
                    href="#contato"
                    class="px-3 py-2 rounded text-[13px] font-brand font-semibold text-[#022B5B] hover:text-[#00509D] hover:bg-slate-100/80 transition whitespace-nowrap"
                >
                    Contato
                </a>
            </nav>

            <!-- Ações Direitas de Precisão (Tablet & Desktop) -->
            <div class="hidden sm:flex items-center gap-2.5 shrink-0">
                <button
                    @click="emit('open-platforms')"
                    type="button"
                    class="h-9 px-3.5 rounded font-brand font-bold text-xs text-[#022B5B] bg-white hover:bg-slate-50 border border-slate-300 hover:border-[#00509D] inline-flex items-center gap-2 whitespace-nowrap transition cursor-pointer"
                >
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Plataformas</span>
                </button>

                <a
                    href="#contato"
                    class="h-9 px-4 rounded font-brand font-bold text-xs uppercase tracking-wider text-white bg-[#022B5B] hover:bg-[#00509D] border-b-2 border-[#00B4D8] inline-flex items-center gap-1.5 whitespace-nowrap transition"
                >
                    <span>Apresentação</span>
                    <span class="text-[#00E5FF]">→</span>
                </a>
            </div>

            <!-- Controles Mobile (Botão Plataformas + Hambúrguer Executivo) -->
            <div class="flex lg:hidden items-center gap-2 shrink-0">
                <button
                    @click="emit('open-platforms')"
                    type="button"
                    class="sm:hidden h-9 px-2.5 rounded font-brand font-bold text-[11px] text-[#022B5B] bg-slate-100 border border-slate-200 inline-flex items-center gap-1.5 whitespace-nowrap"
                >
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>Sistemas</span>
                </button>

                <button
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    type="button"
                    class="h-9 w-9 rounded text-[#022B5B] bg-slate-100 hover:bg-slate-200 border border-slate-200 inline-flex items-center justify-center transition"
                    aria-label="Abrir Menu"
                >
                    <span v-if="!mobileMenuOpen" class="font-bold text-base leading-none">☰</span>
                    <span v-else class="font-bold text-base leading-none">✕</span>
                </button>
            </div>
        </div>

        <!-- Menu Mobile Drawer Executivo (Lista Dinamicamente as Frentes de Atuação Ativas!) -->
        <Transition name="fade-slide">
            <div v-if="mobileMenuOpen" class="lg:hidden bg-[#011328] text-white border-b border-cyan-500/30 px-4 pt-4 pb-6 space-y-4 shadow-2xl">
                <div class="space-y-1.5">
                    <span class="text-[10px] font-brand font-bold uppercase tracking-[0.14em] text-cyan-300 block">
                        Acesso Direto às Plataformas Online
                    </span>
                    <div class="grid grid-cols-2 gap-2.5">
                        <a
                            :href="settings.siscoop3f_url"
                            target="_blank"
                            rel="noopener"
                            class="flex items-center justify-between py-2.5 px-3 rounded bg-white/[0.06] border border-white/10 border-l-2 border-l-[#80FFDB] font-brand font-bold text-xs text-white"
                        >
                            <span>SISCOOP3F</span>
                            <span class="text-[#80FFDB]">↗</span>
                        </a>
                        <a
                            :href="settings.telemedicine_url"
                            target="_blank"
                            rel="noopener"
                            class="flex items-center justify-between py-2.5 px-3 rounded bg-white/[0.06] border border-white/10 border-l-2 border-l-[#00F5D4] font-brand font-bold text-xs text-white"
                        >
                            <span>Telemedicina</span>
                            <span class="text-[#00F5D4]">↗</span>
                        </a>
                    </div>
                </div>

                <!-- Navegação Numerada Dinâmica das Frentes de Atuação Habilitadas -->
                <div class="space-y-1 pt-2 border-t border-white/10">
                    <span class="text-[10px] font-brand font-bold uppercase tracking-[0.14em] text-slate-400 block mb-1.5">
                        Frentes de Atuação Ativas
                    </span>
                    <button
                        v-for="tab in ecosystemTabs"
                        :key="`nav-mob-${tab.key}`"
                        type="button"
                        @click="selectTabAndScroll(tab.key)"
                        class="w-full flex items-center justify-between px-3 py-2.5 rounded bg-white/[0.03] hover:bg-white/[0.08] text-left"
                    >
                        <span class="font-brand font-semibold text-sm text-white">
                            {{ tab.number }} • {{ tab.tab_title }} ({{ tab.tab_subtitle }})
                        </span>
                        <span class="text-xs text-cyan-300">→</span>
                    </button>

                    <a @click="mobileMenuOpen = false" href="#identidade" class="w-full flex items-center justify-between px-3 py-2.5 rounded bg-white/[0.03] hover:bg-white/[0.08]">
                        <span class="font-brand font-semibold text-sm text-cyan-200">Sobre Nós & Liderança Institucional</span>
                        <span class="text-xs text-cyan-200">↓</span>
                    </a>
                    <a @click="mobileMenuOpen = false" href="#gestao-publica" class="w-full flex items-center justify-between px-3 py-2.5 rounded bg-white/[0.03] hover:bg-white/[0.08]">
                        <span class="font-brand font-semibold text-sm text-cyan-200">Soluções para a Gestão Pública</span>
                        <span class="text-xs text-cyan-200">↓</span>
                    </a>
                    <a @click="mobileMenuOpen = false" href="#siscoop3f" class="w-full flex items-center justify-between px-3 py-2.5 rounded bg-white/[0.03] hover:bg-white/[0.08]">
                        <span class="font-brand font-semibold text-sm text-[#80FFDB]">Simulador Financeiro de Eficiência</span>
                        <span class="text-xs text-[#80FFDB]">↓</span>
                    </a>
                </div>

                <a
                    @click="mobileMenuOpen = false"
                    href="#contato"
                    class="block w-full text-center py-3.5 rounded font-brand font-bold text-xs uppercase tracking-[0.12em] text-[#01162E] bg-[#00E5FF]"
                >
                    Agendar Apresentação →
                </a>
            </div>
        </Transition>
    </header>
</template>
