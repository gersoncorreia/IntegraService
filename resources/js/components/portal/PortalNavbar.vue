<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import BrandLogo from '../ui/BrandLogo.vue';

defineProps({
    settings: { type: Object, required: true },
    urls: { type: Object, required: true },
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
                : 'bg-white border-b border-slate-200/80 py-3'
        ]"
    >
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between gap-4">
            <!-- Logo Oficial -->
            <BrandLogo
                :part1="settings.brand_part_1"
                :part2="settings.brand_part_2"
                :tagline="settings.brand_tagline"
                :logoPath="settings.logo_path"
                theme="light"
                size="sm"
                href="#inicio"
            />

            <!-- Navegação Central Executiva (Sem pílulas redondas genéricas) -->
            <nav class="hidden lg:flex items-center gap-0.5">
                <a
                    href="#ecossistema"
                    class="px-3.5 py-2 rounded text-[13px] font-brand font-semibold text-[#022B5B] hover:text-[#00509D] hover:bg-slate-100/80 transition whitespace-nowrap"
                >
                    Soluções
                </a>
                <a
                    href="#siscoop3f"
                    class="px-3.5 py-2 rounded text-[13px] font-brand font-semibold text-[#022B5B] hover:text-[#00509D] hover:bg-slate-100/80 transition inline-flex items-center gap-2 whitespace-nowrap"
                >
                    <span>SISCOOP3F</span>
                    <span class="px-1.5 py-0.5 text-[10px] font-extrabold tracking-wider uppercase rounded-xs bg-[#022B5B] text-[#00E5FF]">
                        30d Free
                    </span>
                </a>
                <button
                    type="button"
                    @click="selectTabAndScroll('clinic')"
                    class="px-3.5 py-2 rounded text-[13px] font-brand font-semibold text-[#022B5B] hover:text-[#00509D] hover:bg-slate-100/80 transition whitespace-nowrap cursor-pointer"
                >
                    Saúde & Clínica
                </button>
                <button
                    type="button"
                    @click="selectTabAndScroll('consulting')"
                    class="px-3.5 py-2 rounded text-[13px] font-brand font-semibold text-[#022B5B] hover:text-[#00509D] hover:bg-slate-100/80 transition whitespace-nowrap cursor-pointer"
                >
                    Consultoria & Livro
                </button>
                <a
                    href="#contato"
                    class="px-3.5 py-2 rounded text-[13px] font-brand font-semibold text-[#022B5B] hover:text-[#00509D] hover:bg-slate-100/80 transition whitespace-nowrap"
                >
                    Contato
                </a>
            </nav>

            <!-- Ações Direitas de Precisão -->
            <div class="hidden sm:flex items-center gap-2.5 shrink-0">
                <a
                    v-if="isAuthenticated"
                    :href="urls.adminDashboard"
                    class="h-9 px-3 rounded font-brand font-bold text-[11px] uppercase tracking-wider text-[#00509D] bg-sky-50 hover:bg-sky-100 border border-sky-200 inline-flex items-center whitespace-nowrap transition"
                >
                    CMS
                </a>

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
                    <span>Proposta</span>
                    <span class="text-[#00E5FF]">→</span>
                </a>
            </div>

            <!-- Botão Menu Mobile -->
            <button
                @click="mobileMenuOpen = !mobileMenuOpen"
                type="button"
                class="lg:hidden p-2 rounded text-[#022B5B] bg-slate-100 hover:bg-slate-200 border border-slate-200 transition"
                aria-label="Abrir Menu"
            >
                <span v-if="!mobileMenuOpen" class="font-bold text-lg">☰</span>
                <span v-else class="font-bold text-lg">✕</span>
            </button>
        </div>

        <!-- Menu Mobile -->
        <Transition name="fade-slide">
            <div v-if="mobileMenuOpen" class="lg:hidden bg-white border-b border-slate-200 px-4 pt-3 pb-5 space-y-2 shadow-xl">
                <div class="grid grid-cols-2 gap-2 pb-3 border-b border-slate-100">
                    <a :href="settings.siscoop3f_url" target="_blank" class="flex items-center justify-center py-2.5 px-3 rounded bg-[#022B5B] text-white font-brand font-bold text-xs">
                        SISCOOP3F ↗
                    </a>
                    <a :href="settings.telemedicine_url" target="_blank" class="flex items-center justify-center py-2.5 px-3 rounded bg-[#0077B6] text-white font-brand font-bold text-xs">
                        Telemedicina ↗
                    </a>
                </div>
                <a @click="mobileMenuOpen = false" href="#ecossistema" class="block px-3 py-2 rounded font-brand font-semibold text-sm text-[#022B5B] hover:bg-slate-50">Soluções (Ecossistema)</a>
                <a @click="mobileMenuOpen = false" href="#siscoop3f" class="block px-3 py-2 rounded font-brand font-semibold text-sm text-[#022B5B] hover:bg-slate-50">SISCOOP3F & Parceria</a>
                <button type="button" @click="selectTabAndScroll('clinic')" class="w-full text-left block px-3 py-2 rounded font-brand font-semibold text-sm text-[#022B5B] hover:bg-slate-50">Saúde & Clínica</button>
                <button type="button" @click="selectTabAndScroll('consulting')" class="w-full text-left block px-3 py-2 rounded font-brand font-semibold text-sm text-[#022B5B] hover:bg-slate-50">Consultoria & Livro</button>
                <a @click="mobileMenuOpen = false" href="#contato" class="block w-full text-center mt-2 py-3 rounded font-brand font-bold text-xs uppercase tracking-wider text-white bg-[#022B5B]">
                    Solicitar Proposta
                </a>
            </div>
        </Transition>
    </header>
</template>
