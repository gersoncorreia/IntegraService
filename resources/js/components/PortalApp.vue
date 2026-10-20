<script setup>
import { ref, computed, onMounted, onUnmounted, nextTick } from 'vue';
import BrandLogo from './ui/BrandLogo.vue';
import AppIcon from './ui/AppIcon.vue';
import PortalNavbar from './portal/PortalNavbar.vue';
import HeroSection from './portal/HeroSection.vue';
import EcosystemExplorerSection from './portal/EcosystemExplorerSection.vue';
import InstitutionalIdentitySection from './portal/InstitutionalIdentitySection.vue';
import ImplementationAndJourneySection from './portal/ImplementationAndJourneySection.vue';
import SiscoopAndSimulatorSection from './portal/SiscoopAndSimulatorSection.vue';
import PublicManagementSection from './portal/PublicManagementSection.vue';
import ContactAndFooterSection from './portal/ContactAndFooterSection.vue';

const props = defineProps({
    initialState: { type: Object, required: true },
});

const platformModalOpen = ref(false);
const activeExplorerTab = ref('siscoop3f');
const selectedVertical = ref('Gestão Cooperativista - SISCOOP3F');
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
    const mapVertical = {
        SISCOOP3F: 'Gestão Cooperativista - SISCOOP3F',
        'Telemedicina 24/7': 'Telemedicina',
        'Consultoria Executiva': 'Consultoria Executiva',
        'Base Científica': 'Base Científica',
    };
    selectedVertical.value = mapVertical[verticalName] || verticalName;
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
    <div :class="['min-h-screen flex flex-col pt-16 sm:pt-20', scrollReady ? 'js-scroll-ready' : '']">
        <!-- 1. Navbar Arquitetônica Executiva (Fixa com Rolagem) -->
        <PortalNavbar
            :settings="initialState.settings"
            :urls="initialState.urls"
            :ecosystemTabs="initialState.ecosystemTabs || []"
            :isAuthenticated="initialState.isAuthenticated"
            @open-platforms="platformModalOpen = true"
            @navigate-tab="handleNavigateTab"
        />

        <!-- Ordem Recomendada das Seções (Seção 7 do Diagnóstico Oficial) -->
        <main class="flex-1">
            <!-- 2. Abertura Institucional, Proposta de Valor & Segmentação por Público -->
            <HeroSection
                v-if="initialState.sections?.hero"
                :hero="initialState.sections.hero"
                :settings="initialState.settings"
                @select-audience="handleNavigateTab"
            />

            <!-- 3. Quatro Soluções com Explicação Individual (100% Dinâmico via CMS!) -->
            <EcosystemExplorerSection
                :ecosystem="initialState.sections?.ecosystem"
                :ecosystemTabs="initialState.ecosystemTabs || []"
                :departments="initialState.departments || []"
                :featuredBook="initialState.featuredBook"
                :settings="initialState.settings"
                :externalTab="activeExplorerTab"
                @select-vertical="handleSelectVertical"
            />

            <!-- 4. Modelo de Implantação Planejada & Jornada Comercial em 5 Etapas -->
            <ImplementationAndJourneySection
                v-if="initialState.sections?.implementation_plan"
                :implementationSection="initialState.sections.implementation_plan"
                @select-vertical="handleSelectVertical"
            />

            <!-- 5. Simulador Financeiro com Premissas, Memória de Cálculo & Ressalvas Legais -->
            <SiscoopAndSimulatorSection
                :siscoop="initialState.sections?.siscoop3f"
                :investment="initialState.sections?.investment_model"
                :settings="initialState.settings"
                @select-vertical="handleSelectVertical"
            />

            <!-- 6. Seção Dedicada à Gestão Pública & Municípios -->
            <PublicManagementSection
                v-if="initialState.sections?.public_management"
                :publicSection="initialState.sections.public_management"
                @select-vertical="handleSelectVertical"
            />

            <!-- 7. Quem Somos, Identidade Institucional & Liderança Executiva (Eudemir Bezerra) -->
            <InstitutionalIdentitySection
                v-if="initialState.sections?.institutional_identity"
                :identitySection="initialState.sections.institutional_identity"
                :settings="initialState.settings"
                @select-vertical="handleSelectVertical"
            />

            <!-- 8. Agendamento de Apresentação, Formulário Simplificado & Rodapé com LGPD -->
            <ContactAndFooterSection
                :contact="initialState.sections?.contact"
                :settings="initialState.settings"
                :urls="initialState.urls"
                :ecosystemTabs="initialState.ecosystemTabs || []"
                :selectedVertical="selectedVertical"
                :preselectedUsers="preselectedUsers"
            />
        </main>

        <!-- 9. Barra de Ação Rápida Mobile para Polegar (Mobile Bottom Action Dock) -->
        <nav
            aria-label="Ações Rápidas Mobile"
            class="lg:hidden fixed bottom-0 inset-x-0 z-40 bg-[#011328]/95 backdrop-blur-md border-t border-cyan-500/30 shadow-[0_-8px_30px_rgba(1,19,40,0.6)] pb-safe"
        >
            <div class="grid grid-cols-3 divide-x divide-white/10 h-14">
                <a
                    href="#ecossistema"
                    class="flex flex-col items-center justify-center gap-0.5 text-slate-200 active:bg-white/10 transition"
                >
                    <AppIcon name="network" class="w-4 h-4 text-[#00E5FF]" />
                    <span class="font-brand font-bold text-[10px] uppercase tracking-wider">
                        {{ (initialState.ecosystemTabs?.length || 4) }} Soluções
                    </span>
                </a>

                <a
                    href="#siscoop3f"
                    class="flex flex-col items-center justify-center gap-0.5 text-slate-200 active:bg-white/10 transition"
                >
                    <AppIcon name="chart-bar" class="w-4 h-4 text-[#80FFDB]" />
                    <span class="font-brand font-bold text-[10px] uppercase tracking-wider">Simulador</span>
                </a>

                <a
                    href="#contato"
                    class="flex flex-col items-center justify-center gap-0.5 bg-[#00E5FF] text-[#011328] active:bg-[#80FFDB] transition"
                >
                    <span class="font-brand font-extrabold text-[10px] uppercase tracking-wider">Apresentação →</span>
                    <span class="font-brand font-semibold text-[9px] uppercase tracking-tight opacity-85">Falar com Equipe</span>
                </a>
            </div>
        </nav>

        <!-- Modal de Acesso Rápido às Plataformas -->
        <Transition name="modal-fade">
            <div
                v-if="platformModalOpen"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
                @click.self="platformModalOpen = false"
            >
                <div class="w-full max-w-xl rounded-lg bg-[#01162E] border border-cyan-500/30 text-white shadow-2xl relative overflow-hidden">
                    <div class="h-1 w-full bg-gradient-to-r from-[#00509D] via-[#00B4D8] to-[#00E5FF]"></div>

                    <div class="p-5 sm:p-9">
                        <div class="flex items-center justify-between pb-4 sm:pb-5 border-b border-white/10">
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

                        <div class="mt-4 sm:mt-5">
                            <span class="text-[10px] sm:text-[11px] font-brand font-bold uppercase tracking-[0.16em] text-[#00E5FF]">
                                Ambientes Digitais Ativos
                            </span>
                            <h3 class="font-brand text-lg sm:text-2xl font-extrabold mt-1">
                                Central de Acesso às Plataformas
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-300 mt-1">
                                Selecione o sistema oficial para iniciar sua sessão com segurança:
                            </p>
                        </div>

                        <div class="mt-5 sm:mt-6 space-y-3">
                            <a
                                :href="initialState.settings.siscoop3f_url"
                                target="_blank"
                                rel="noopener"
                                class="group flex items-center justify-between gap-3 p-4 sm:p-5 rounded-md bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 hover:border-[#80FFDB]/60 border-l-4 border-l-[#80FFDB] transition-all"
                            >
                                <div class="min-w-0">
                                    <span class="text-[10px] font-brand font-bold uppercase tracking-widest text-[#80FFDB] block">
                                        GESTÃO COOPERATIVISTA
                                    </span>
                                    <h4 class="font-brand text-base sm:text-lg font-bold text-white mt-0.5">
                                        Plataforma SISCOOP3F
                                    </h4>
                                    <span class="text-[11px] sm:text-xs text-slate-400 font-mono block mt-0.5 truncate">
                                        {{ initialState.settings.siscoop3f_url }}
                                    </span>
                                </div>
                                <span class="px-3 py-2 rounded bg-[#80FFDB] text-[#01162E] font-brand font-bold text-xs tracking-wide shrink-0 whitespace-nowrap">
                                    Acessar ↗
                                </span>
                            </a>

                            <a
                                :href="initialState.settings.telemedicine_url"
                                target="_blank"
                                rel="noopener"
                                class="group flex items-center justify-between gap-3 p-4 sm:p-5 rounded-md bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 hover:border-[#00F5D4]/60 border-l-4 border-l-[#00F5D4] transition-all"
                            >
                                <div class="min-w-0">
                                    <span class="text-[10px] font-brand font-bold uppercase tracking-widest text-[#00F5D4] block">
                                        SAÚDE DIGITAL 24/7
                                    </span>
                                    <h4 class="font-brand text-base sm:text-lg font-bold text-white mt-0.5">
                                        Portal de Telemedicina
                                    </h4>
                                    <span class="text-[11px] sm:text-xs text-slate-400 font-mono block mt-0.5 truncate">
                                        {{ initialState.settings.telemedicine_url }}
                                    </span>
                                </div>
                                <span class="px-3 py-2 rounded bg-[#00F5D4] text-[#03045E] font-brand font-bold text-xs tracking-wide shrink-0 whitespace-nowrap">
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
