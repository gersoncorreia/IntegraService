<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue';
import BrandLogo from './ui/BrandLogo.vue';
import PortalNavbar from './portal/PortalNavbar.vue';
import HeroSection from './portal/HeroSection.vue';
import EcosystemExplorerSection from './portal/EcosystemExplorerSection.vue';
import SiscoopAndSimulatorSection from './portal/SiscoopAndSimulatorSection.vue';
import ContactAndFooterSection from './portal/ContactAndFooterSection.vue';

defineProps({
    initialState: { type: Object, required: true },
});

const platformModalOpen = ref(false);
const activeExplorerTab = ref('siscoop3f');
const selectedVertical = ref('SISCOOP3F - Gestão Cooperativista');
const preselectedUsers = ref(null);
const scrollReady = ref(false);

let revealObserver = null;

const observeElements = () => {
    const elements = document.querySelectorAll('[data-reveal]');
    elements.forEach((el) => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.92 && rect.bottom > 0) {
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    el.classList.add('is-revealed');
                });
            });
        } else if (revealObserver) {
            revealObserver.observe(el);
        }
    });
};

onMounted(async () => {
    await nextTick();
    scrollReady.value = true;

    if ('IntersectionObserver' in window) {
        revealObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-revealed');
                        revealObserver.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
        );
        observeElements();
    } else {
        document.querySelectorAll('[data-reveal]').forEach((el) => el.classList.add('is-revealed'));
    }
});

onUnmounted(() => {
    if (revealObserver) {
        revealObserver.disconnect();
    }
});

const handleNavigateTab = (tabKey) => {
    activeExplorerTab.value = tabKey;
};

const handleSelectVertical = (verticalName, users = null) => {
    selectedVertical.value = verticalName;
    if (users) {
        preselectedUsers.value = users;
    }
    const el = document.getElementById('contato');
    if (el) {
        el.scrollIntoView({ behavior: 'smooth' });
    }
};
</script>

<template>
    <div :class="['min-h-screen flex flex-col', scrollReady ? 'js-scroll-ready' : '']">
        <!-- 1. Navbar Arquitetônica Executiva -->
        <PortalNavbar
            :settings="initialState.settings"
            :urls="initialState.urls"
            :isAuthenticated="initialState.isAuthenticated"
            @open-platforms="platformModalOpen = true"
            @navigate-tab="handleNavigateTab"
        />

        <main class="flex-1">
            <!-- 2. Hero Editorial & Painel Operacional -->
            <HeroSection
                v-if="initialState.sections?.hero"
                :hero="initialState.sections.hero"
                :settings="initialState.settings"
            />

            <!-- 3. Explorador Interativo das 5 Verticais em Abas Estruturadas -->
            <EcosystemExplorerSection
                :ecosystem="initialState.sections?.ecosystem"
                :siscoop="initialState.sections?.siscoop3f"
                :telemedicine="initialState.sections?.telemedicine"
                :clinic="initialState.sections?.clinic"
                :departments="initialState.departments || []"
                :consulting="initialState.sections?.consulting"
                :book="initialState.sections?.book"
                :featuredBook="initialState.featuredBook"
                :settings="initialState.settings"
                :externalTab="activeExplorerTab"
                @select-vertical="handleSelectVertical"
            />

            <!-- 4. Destaque Comercial SISCOOP3F & Simulador Financeiro Estruturado -->
            <SiscoopAndSimulatorSection
                :siscoop="initialState.sections?.siscoop3f"
                :investment="initialState.sections?.investment_model"
                :settings="initialState.settings"
                @select-vertical="handleSelectVertical"
            />

            <!-- 5. Solicitação de Proposta & Rodapé Executivo -->
            <ContactAndFooterSection
                :contact="initialState.sections?.contact"
                :settings="initialState.settings"
                :urls="initialState.urls"
                :selectedVertical="selectedVertical"
                :preselectedUsers="preselectedUsers"
            />
        </main>

        <!-- Modal de Acesso Rápido às Plataformas (Geometria Executiva Precisa) -->
        <Transition name="modal-fade">
            <div
                v-if="platformModalOpen"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
                @click.self="platformModalOpen = false"
            >
                <div class="w-full max-w-xl rounded-lg bg-[#01162E] border border-cyan-500/30 text-white shadow-2xl relative overflow-hidden">
                    <!-- Barra Superior de Destaque -->
                    <div class="h-1 w-full bg-gradient-to-r from-[#00509D] via-[#00B4D8] to-[#00E5FF]"></div>

                    <div class="p-7 sm:p-9">
                        <div class="flex items-center justify-between pb-5 border-b border-white/10">
                            <BrandLogo
                                :part1="initialState.settings.brand_part_1"
                                :part2="initialState.settings.brand_part_2"
                                :tagline="initialState.settings.brand_tagline"
                                :logoPath="initialState.settings.logo_path"
                                theme="dark"
                                size="sm"
                            />
                            <button
                                @click="platformModalOpen = false"
                                type="button"
                                class="w-8 h-8 rounded-md bg-white/5 hover:bg-white/15 border border-white/10 flex items-center justify-center text-slate-300 hover:text-white transition cursor-pointer"
                            >
                                ✕
                            </button>
                        </div>

                        <div class="mt-5">
                            <span class="text-[11px] font-brand font-bold uppercase tracking-[0.16em] text-[#00E5FF]">
                                Ambientes em Produção
                            </span>
                            <h3 class="font-brand text-xl sm:text-2xl font-extrabold mt-1">
                                Central de Acesso às Plataformas
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-300 mt-1">
                                Selecione o sistema oficial para iniciar sua sessão com segurança:
                            </p>
                        </div>

                        <div class="mt-6 space-y-3">
                            <a
                                :href="initialState.settings.siscoop3f_url"
                                target="_blank"
                                rel="noopener"
                                class="group flex items-center justify-between p-4 sm:p-5 rounded-md bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 hover:border-[#80FFDB]/60 border-l-4 border-l-[#80FFDB] transition-all"
                            >
                                <div>
                                    <span class="text-[10px] font-brand font-bold uppercase tracking-widest text-[#80FFDB] block">
                                        GESTÃO COOPERATIVISTA • 30 DIAS SEM CUSTO
                                    </span>
                                    <h4 class="font-brand text-base sm:text-lg font-bold text-white mt-0.5">
                                        Plataforma SISCOOP3F
                                    </h4>
                                    <span class="text-xs text-slate-400 font-mono block mt-0.5">
                                        {{ initialState.settings.siscoop3f_url }}
                                    </span>
                                </div>
                                <span class="px-3.5 py-2 rounded bg-[#80FFDB] text-[#01162E] font-brand font-bold text-xs tracking-wide shrink-0 group-hover:translate-x-0.5 transition-transform">
                                    Acessar ↗
                                </span>
                            </a>

                            <a
                                :href="initialState.settings.telemedicine_url"
                                target="_blank"
                                rel="noopener"
                                class="group flex items-center justify-between p-4 sm:p-5 rounded-md bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 hover:border-[#00F5D4]/60 border-l-4 border-l-[#00F5D4] transition-all"
                            >
                                <div>
                                    <span class="text-[10px] font-brand font-bold uppercase tracking-widest text-[#00F5D4] block">
                                        SAÚDE DIGITAL 24/7
                                    </span>
                                    <h4 class="font-brand text-base sm:text-lg font-bold text-white mt-0.5">
                                        Portal de Telemedicina
                                    </h4>
                                    <span class="text-xs text-slate-400 font-mono block mt-0.5">
                                        {{ initialState.settings.telemedicine_url }}
                                    </span>
                                </div>
                                <span class="px-3.5 py-2 rounded bg-[#00F5D4] text-[#03045E] font-brand font-bold text-xs tracking-wide shrink-0 group-hover:translate-x-0.5 transition-transform">
                                    Login ↗
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>
