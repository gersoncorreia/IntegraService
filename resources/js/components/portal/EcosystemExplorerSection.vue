<script setup>
import { ref, computed, watch } from 'vue';
import BrandLogo from '../ui/BrandLogo.vue';
import AppIcon from '../ui/AppIcon.vue';

const props = defineProps({
    ecosystem: { type: Object, default: null },
    ecosystemTabs: { type: Array, default: () => [] },
    departments: { type: Array, default: () => [] },
    featuredBook: { type: Object, default: null },
    settings: { type: Object, required: true },
    externalTab: { type: String, default: '' },
});

const emit = defineEmits(['select-vertical']);

const activeTab = ref(
    props.externalTab || (props.ecosystemTabs[0]?.key ?? 'siscoop3f')
);
const activeDeptIdx = ref(0);
const deptDetailRef = ref(null);

watch(
    () => props.externalTab,
    (newTab) => {
        if (newTab && props.ecosystemTabs.some((t) => t.key === newTab)) {
            activeTab.value = newTab;
        }
    }
);

watch(
    () => props.ecosystemTabs,
    (newTabs) => {
        if (newTabs.length && !newTabs.some((t) => t.key === activeTab.value)) {
            activeTab.value = newTabs[0].key;
        }
    },
    { immediate: true }
);

const currentTabObj = computed(() => {
    return (
        props.ecosystemTabs.find((t) => t.key === activeTab.value) ||
        props.ecosystemTabs[0] ||
        null
    );
});

const selectDepartment = (idx) => {
    activeDeptIdx.value = idx;
    if (window.innerWidth < 1024 && deptDetailRef.value) {
        deptDetailRef.value.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
};

const currentDepartment = computed(() => props.departments[activeDeptIdx.value] || null);

// Calcula dinamicamente quantas colunas usar no desktop de acordo com o número de frentes ativas
const desktopGridColsClass = computed(() => {
    const count = props.ecosystemTabs.length;
    if (count <= 1) return 'lg:grid-cols-1';
    if (count === 2) return 'lg:grid-cols-2';
    if (count === 3) return 'lg:grid-cols-3';
    if (count === 4) return 'lg:grid-cols-4';
    if (count === 5) return 'lg:grid-cols-5';
    return 'lg:grid-cols-6';
});

const isExternalUrl = (url) => {
    return typeof url === 'string' && (url.startsWith('http://') || url.startsWith('https://'));
};
</script>

<template>
    <section
        v-if="ecosystemTabs.length"
        id="ecossistema"
        class="py-16 sm:py-24 section-light-grid border-b border-slate-200/80 relative"
    >
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <!-- Cabeçalho Editorial Estruturado -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 sm:gap-6 mb-8 sm:mb-10" data-reveal>
                <div>
                    <div class="inline-flex items-center gap-2.5 pl-3 pr-3.5 py-1 bg-[#022B5B]/[0.06] border-l-2 border-[#00509D] rounded-r mb-3">
                        <span class="font-brand text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.14em] text-[#00509D]">
                            {{ ecosystem?.badge_text || `NOSSAS ${ecosystemTabs.length} FRENTES DE ATUAÇÃO` }}
                        </span>
                    </div>
                    <h2 class="font-brand text-2xl sm:text-4xl font-extrabold text-[#022B5B] leading-tight tracking-[-0.02em]">
                        {{ ecosystem?.title || 'Tudo o que sua instituição precisa em' }}
                        <span class="text-[#0077B6]">{{ ecosystem?.highlighted_word || 'um único ecossistema' }}</span>
                    </h2>
                </div>
                <p class="text-slate-600 text-sm sm:text-base max-w-md leading-relaxed">
                    {{ ecosystem?.subtitle || 'Selecione abaixo uma área de atuação para explorar os recursos de forma rápida e direta.' }}
                </p>
            </div>

            <!-- Barra Arquitetônica Dinâmica de Abas Numeradas (100% Controlada pelo Painel Admin!) -->
            <div
                :class="[
                    'grid grid-cols-2 sm:grid-cols-3 bg-white border border-slate-200 rounded-t-lg shadow-xs overflow-hidden divide-y divide-x divide-slate-200',
                    desktopGridColsClass
                ]"
                data-reveal
            >
                <button
                    v-for="(tab, index) in ecosystemTabs"
                    :key="tab.key"
                    type="button"
                    @click="activeTab = tab.key"
                    :class="[
                        'group relative p-3.5 sm:p-5 text-left transition-all duration-200 cursor-pointer flex flex-col justify-between',
                        ecosystemTabs.length % 2 === 1 && index === ecosystemTabs.length - 1 ? 'col-span-2 sm:col-span-1' : '',
                        activeTab === tab.key
                            ? 'bg-[#022B5B] text-white'
                            : 'bg-white text-[#022B5B] hover:bg-slate-50/90'
                    ]"
                >
                    <!-- Indicador Superior de Aba Ativa -->
                    <span
                        :class="[
                            'absolute top-0 left-0 right-0 h-1 transition-opacity',
                            activeTab === tab.key ? 'bg-[#00E5FF] opacity-100' : 'opacity-0 group-hover:opacity-40 bg-[#0077B6]'
                        ]"
                    ></span>

                    <div class="flex items-center justify-between gap-2 mb-2 sm:mb-3">
                        <span
                            :class="[
                                'font-mono text-[10px] sm:text-[11px] font-bold tracking-wider px-1.5 py-0.5 rounded-xs',
                                activeTab === tab.key ? 'bg-white/10 text-[#00E5FF]' : 'bg-slate-100 text-slate-500'
                            ]"
                        >
                            {{ tab.number }}
                        </span>
                        <AppIcon
                            :name="tab.tab_icon"
                            :class="[
                                'w-4 h-4 sm:w-5 sm:h-5 transition-colors',
                                activeTab === tab.key ? 'text-[#00E5FF]' : 'text-[#0077B6]'
                            ]"
                        />
                    </div>

                    <div>
                        <span class="font-brand font-extrabold text-xs sm:text-[15px] block tracking-tight">
                            {{ tab.tab_title }}
                        </span>
                        <span
                            :class="[
                                'text-[11px] block mt-0.5 truncate',
                                activeTab === tab.key ? 'text-cyan-200' : 'text-slate-500'
                            ]"
                        >
                            {{ tab.tab_subtitle }}
                        </span>
                    </div>
                </button>
            </div>

            <!-- Painel Dinâmico Conectado à Barra de Abas -->
            <Transition name="fade-slide" mode="out-in">
                <div v-if="currentTabObj" :key="currentTabObj.key">
                    <!-- ===============================================================
                         TIPO ESPECIAL 1: A CLÍNICA & DEPARTAMENTOS (tab_type === 'clinic')
                         =============================================================== -->
                    <div
                        v-if="currentTabObj.tab_type === 'clinic'"
                        class="rounded-b-lg bg-white border-x border-b border-slate-200 p-5 sm:p-10 shadow-[0_16px_40px_rgba(2,43,91,0.05)]"
                    >
                        <div class="grid lg:grid-cols-12 gap-6 lg:gap-8 items-start">
                            <div class="lg:col-span-5 space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-brand font-bold uppercase tracking-wider text-[#00509D]">
                                        {{ currentTabObj.number }} • Selecione o Departamento Clínico:
                                    </span>
                                    <span class="text-[11px] font-mono text-slate-400">{{ departments.length }} unidades</span>
                                </div>

                                <!-- No Celular (< lg): Chips Horizontais -->
                                <div class="flex lg:hidden items-center gap-2 overflow-x-auto no-scrollbar pb-2 pt-1 snap-x">
                                    <button
                                        v-for="(dept, idx) in departments"
                                        :key="`mob-${dept.id}`"
                                        type="button"
                                        @click="selectDepartment(idx)"
                                        :class="[
                                            'snap-start shrink-0 px-3.5 py-2.5 rounded border font-brand font-bold text-xs flex items-center gap-2 transition',
                                            activeDeptIdx === idx
                                                ? 'bg-[#022B5B] text-white border-[#022B5B] border-b-2 border-b-[#00E5FF] shadow-xs'
                                                : 'bg-[#F8FAFC] text-[#022B5B] border-slate-200'
                                        ]"
                                    >
                                        <AppIcon
                                            :name="dept.icon"
                                            :class="['w-4 h-4 shrink-0', activeDeptIdx === idx ? 'text-[#00E5FF]' : 'text-[#0077B6]']"
                                        />
                                        <span class="whitespace-nowrap">{{ dept.name }}</span>
                                    </button>
                                </div>

                                <!-- No Desktop (lg+): Lista Vertical -->
                                <div class="hidden lg:grid grid-cols-1 gap-2 max-h-[380px] overflow-y-auto pr-1">
                                    <button
                                        v-for="(dept, idx) in departments"
                                        :key="dept.id"
                                        type="button"
                                        @click="selectDepartment(idx)"
                                        :class="[
                                            'w-full text-left px-4 py-3 rounded border transition flex items-center justify-between gap-3 cursor-pointer',
                                            activeDeptIdx === idx
                                                ? 'bg-[#022B5B] text-white border-[#022B5B] border-l-4 border-l-[#00E5FF] shadow-xs'
                                                : 'bg-[#F8FAFC] text-[#022B5B] border-slate-200 hover:bg-slate-100'
                                        ]"
                                    >
                                        <div class="flex items-center gap-3 min-w-0">
                                            <AppIcon
                                                :name="dept.icon"
                                                :class="['w-4 h-4 shrink-0', activeDeptIdx === idx ? 'text-[#00E5FF]' : 'text-[#0077B6]']"
                                            />
                                            <span class="font-brand font-bold text-sm truncate">{{ dept.name }}</span>
                                        </div>
                                        <span :class="['text-xs shrink-0', activeDeptIdx === idx ? 'text-[#00E5FF]' : 'text-slate-400']">→</span>
                                    </button>
                                </div>
                            </div>

                            <div
                                v-if="currentDepartment"
                                ref="deptDetailRef"
                                class="lg:col-span-7 bg-[#F8FAFC] rounded-md p-5 sm:p-8 border border-slate-200 border-t-4 border-t-[#022B5B] space-y-4 sm:space-y-5"
                            >
                                <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-slate-200">
                                    <BrandLogo
                                        :part1="settings.brand_part_1"
                                        :part2="settings.brand_part_2"
                                        :tagline="currentDepartment.custom_tagline"
                                        :logoPath="settings.logo_path"
                                        theme="turquoise"
                                        size="sm"
                                        href="#contato"
                                    />
                                    <span class="text-[10px] sm:text-[11px] font-brand font-bold uppercase tracking-wider text-[#00509D] bg-sky-100/80 px-2.5 py-1 rounded-xs">
                                        {{ currentDepartment.badge }}
                                    </span>
                                </div>

                                <div>
                                    <h3 class="font-brand text-xl sm:text-2xl font-extrabold text-[#022B5B]">
                                        {{ currentDepartment.name }}
                                    </h3>
                                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed mt-1.5 sm:mt-2">
                                        {{ currentDepartment.short_description }}
                                    </p>
                                </div>

                                <div v-if="currentDepartment.features?.length" class="grid sm:grid-cols-2 gap-2.5 pt-1">
                                    <div
                                        v-for="(feat, fIdx) in currentDepartment.features"
                                        :key="fIdx"
                                        class="flex items-center gap-2.5 p-3 rounded bg-white border border-slate-200 text-xs sm:text-sm text-slate-700 font-medium"
                                    >
                                        <span class="w-4 h-4 rounded-xs bg-[#00B4D8]/15 text-[#0077B6] flex items-center justify-center font-bold text-[10px] shrink-0">✓</span>
                                        <span>{{ feat }}</span>
                                    </div>
                                </div>

                                <div class="pt-1 sm:pt-2">
                                    <button
                                        type="button"
                                        @click="emit('select-vertical', currentTabObj.tab_title)"
                                        class="w-full sm:w-auto px-6 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider text-white bg-[#022B5B] hover:bg-[#00509D] border-b-2 border-[#00E5FF] transition cursor-pointer"
                                    >
                                        {{ currentDepartment.cta_text }} →
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===============================================================
                         TIPO ESPECIAL 2: O LIVRO & AUTORIDADE (tab_type === 'book')
                         =============================================================== -->
                    <div
                        v-else-if="currentTabObj.tab_type === 'book' && featuredBook"
                        class="rounded-b-lg bg-[#01162E] text-white border-x border-b border-cyan-500/30 p-5 sm:p-10 shadow-xl"
                    >
                        <div class="grid lg:grid-cols-12 gap-7 lg:gap-12 items-center">
                            <div class="lg:col-span-4 flex justify-center book-3d-wrapper py-2">
                                <div class="book-3d w-48 sm:w-56 rounded-r-md rounded-l-xs bg-gradient-to-br from-[#022B5B] via-[#003566] to-[#00509D] border border-cyan-300/40 p-5 sm:p-6 shadow-2xl relative">
                                    <div class="absolute top-0 bottom-0 left-0 w-3 bg-[#011124] border-r border-white/15"></div>
                                    <div class="pl-2 flex flex-col justify-between min-h-[220px] sm:min-h-[260px] text-center">
                                        <div>
                                            <span class="text-[9px] font-brand font-bold uppercase tracking-widest text-[#00E5FF] block">
                                                {{ featuredBook.category }} • {{ featuredBook.year }}
                                            </span>
                                            <img :src="settings.logo_path" alt="Logo IS" class="h-10 sm:h-12 w-auto mx-auto my-3">
                                            <h4 class="font-brand text-xs sm:text-sm font-extrabold text-white leading-snug">
                                                {{ featuredBook.title }}
                                            </h4>
                                        </div>
                                        <div class="pt-3 border-t border-white/15 text-xs text-cyan-200 font-brand font-bold">
                                            {{ featuredBook.author }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="lg:col-span-8 space-y-4">
                                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xs bg-[#00E5FF]/15 text-[#00E5FF] font-brand font-bold text-[10px] sm:text-[11px] uppercase tracking-wider">
                                    <span>{{ currentTabObj.number }} • {{ currentTabObj.badge_text || 'AUTORIDADE CIENTÍFICA & INTELECTUAL' }}</span>
                                </div>

                                <h3 class="font-brand text-xl sm:text-3xl font-extrabold text-white">
                                    {{ featuredBook.title }}
                                </h3>

                                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                                    {{ featuredBook.summary }}
                                </p>

                                <div v-if="featuredBook.highlights?.length" class="grid sm:grid-cols-2 gap-2.5 pt-1">
                                    <div
                                        v-for="(hl, hIdx) in featuredBook.highlights"
                                        :key="hIdx"
                                        class="flex items-center gap-2.5 p-3 rounded bg-white/[0.04] border border-white/10 text-xs sm:text-sm text-cyan-100"
                                    >
                                        <span class="text-[#00E5FF] font-bold">✦</span>
                                        <span>{{ hl }}</span>
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <button
                                        type="button"
                                        @click="emit('select-vertical', currentTabObj.tab_title)"
                                        class="w-full sm:w-auto px-6 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider text-[#01162E] bg-[#00E5FF] hover:bg-[#80FFDB] transition cursor-pointer"
                                    >
                                        {{ featuredBook.cta_text }} →
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ===============================================================
                         TIPO PADRÃO DINÂMICO: PAINEL DE FRENTE DE ATUAÇÃO + CARDS
                         Suporta Tema Escuro (como Telemedicina) e Tema Claro (como SISCOOP3F/Consultoria)
                         e qualquer Nova Frente de Atuação adicionada pelo Painel Admin!
                         =============================================================== -->
                    <div
                        v-else
                        :class="[
                            'rounded-b-lg border-x border-b p-5 sm:p-10',
                            currentTabObj.tab_theme === 'dark'
                                ? 'bg-[#021B3A] text-white border-cyan-500/30 shadow-xl'
                                : 'bg-white text-[#022B5B] border-slate-200 shadow-[0_16px_40px_rgba(2,43,91,0.05)]'
                        ]"
                    >
                        <div class="grid lg:grid-cols-12 gap-7 lg:gap-12 items-start">
                            <!-- Coluna Esquerda: Contexto Executivo da Frente -->
                            <div class="lg:col-span-5 space-y-4 sm:space-y-5 lg:pr-4">
                                <div
                                    :class="[
                                        'inline-flex items-center gap-2 px-2.5 py-1 rounded-xs font-brand font-bold text-[10px] sm:text-[11px] uppercase tracking-wider',
                                        currentTabObj.tab_theme === 'dark'
                                            ? 'bg-[#00F5D4]/15 text-[#00F5D4]'
                                            : 'bg-[#004E89]/10 text-[#004E89]'
                                    ]"
                                >
                                    <span>{{ currentTabObj.number }} • {{ currentTabObj.badge_text || currentTabObj.tab_subtitle }}</span>
                                </div>

                                <h3
                                    :class="[
                                        'font-brand text-xl sm:text-3xl font-extrabold tracking-tight leading-snug',
                                        currentTabObj.tab_theme === 'dark' ? 'text-white' : 'text-[#022B5B]'
                                    ]"
                                >
                                    {{ currentTabObj.title }}
                                    <span
                                        v-if="currentTabObj.highlighted_word"
                                        :class="currentTabObj.tab_theme === 'dark' ? 'text-[#00F5D4]' : 'text-[#0077B6]'"
                                    >
                                        {{ currentTabObj.highlighted_word }}
                                    </span>
                                </h3>

                                <p
                                    :class="[
                                        'text-sm sm:text-base leading-relaxed',
                                        currentTabObj.tab_theme === 'dark' ? 'text-slate-300' : 'text-slate-600'
                                    ]"
                                >
                                    {{ currentTabObj.subtitle }}
                                </p>

                                <!-- Botões de Ação da Frente -->
                                <div class="pt-1 sm:pt-2 flex flex-col sm:flex-row flex-wrap gap-2.5 sm:gap-3">
                                    <!-- Botão Primário -->
                                    <a
                                        v-if="currentTabObj.primary_cta_url && isExternalUrl(currentTabObj.primary_cta_url)"
                                        :href="currentTabObj.primary_cta_url"
                                        target="_blank"
                                        rel="noopener"
                                        :class="[
                                            'w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider transition text-center',
                                            currentTabObj.tab_theme === 'dark'
                                                ? 'text-[#01162E] bg-[#00F5D4] hover:bg-white'
                                                : 'text-white bg-[#022B5B] hover:bg-[#00509D] border-b-2 border-[#00E5FF]'
                                        ]"
                                    >
                                        <span>{{ currentTabObj.primary_cta_text || 'Acessar Plataforma' }}</span>
                                        <span>↗</span>
                                    </a>
                                    <button
                                        v-else
                                        type="button"
                                        @click="emit('select-vertical', currentTabObj.tab_title)"
                                        :class="[
                                            'w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider transition cursor-pointer text-center',
                                            currentTabObj.tab_theme === 'dark'
                                                ? 'text-[#01162E] bg-[#00F5D4] hover:bg-white'
                                                : 'text-white bg-[#022B5B] hover:bg-[#00509D] border-b-2 border-[#00E5FF]'
                                        ]"
                                    >
                                        <span>{{ currentTabObj.primary_cta_text || 'Solicitar Proposta Comercial' }}</span>
                                        <span>→</span>
                                    </button>

                                    <!-- Botão Secundário -->
                                    <a
                                        v-if="currentTabObj.key === 'siscoop3f'"
                                        href="#siscoop3f"
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider text-[#022B5B] bg-slate-100 hover:bg-slate-200/80 border border-slate-200 transition text-center"
                                    >
                                        <span>Simulador Financeiro</span>
                                        <span>↓</span>
                                    </a>
                                    <button
                                        v-else-if="currentTabObj.secondary_cta_text"
                                        type="button"
                                        @click="emit('select-vertical', currentTabObj.tab_title)"
                                        :class="[
                                            'w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider transition cursor-pointer text-center',
                                            currentTabObj.tab_theme === 'dark'
                                                ? 'text-white bg-white/10 hover:bg-white/15 border border-white/20'
                                                : 'text-[#022B5B] bg-slate-100 hover:bg-slate-200/80 border border-slate-200'
                                        ]"
                                    >
                                        <span>{{ currentTabObj.secondary_cta_text }}</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Coluna Direita: Lista Horizontal de Diferenciais da Frente -->
                            <div class="lg:col-span-7 space-y-3">
                                <div
                                    v-for="(item, index) in (currentTabObj.items || [])"
                                    :key="item.id || index"
                                    :class="[
                                        'exec-card p-4 sm:p-5 rounded-md border border-l-4 flex items-start gap-3.5 sm:gap-4',
                                        currentTabObj.tab_theme === 'dark'
                                            ? 'bg-white/[0.05] hover:bg-white/[0.08] border-white/10 border-l-[#00F5D4]'
                                            : 'bg-[#F8FAFC] hover:bg-white border-slate-200/90 border-l-[#00509D] shadow-2xs'
                                    ]"
                                >
                                    <div
                                        :class="[
                                            'w-10 h-10 sm:w-11 sm:h-11 rounded flex items-center justify-center shrink-0 mt-0.5',
                                            currentTabObj.tab_theme === 'dark'
                                                ? 'bg-[#00F5D4]/15 text-[#00F5D4] border border-[#00F5D4]/30'
                                                : 'bg-[#022B5B] text-[#00E5FF]'
                                        ]"
                                    >
                                        <AppIcon :name="item.icon || currentTabObj.tab_icon" class="w-5 h-5" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center justify-between gap-1.5 sm:gap-2">
                                            <h4
                                                :class="[
                                                    'font-brand font-bold text-sm sm:text-base',
                                                    currentTabObj.tab_theme === 'dark' ? 'text-white' : 'text-[#022B5B]'
                                                ]"
                                            >
                                                {{ item.title }}
                                            </h4>
                                            <span
                                                v-if="item.highlight_metric"
                                                :class="[
                                                    'px-2 py-0.5 rounded-xs font-brand font-bold text-[10px] uppercase tracking-wider',
                                                    currentTabObj.tab_theme === 'dark'
                                                        ? 'bg-[#00F5D4]/15 text-[#00F5D4]'
                                                        : 'bg-[#0077B6]/10 text-[#0077B6]'
                                                ]"
                                            >
                                                {{ item.highlight_metric }}
                                            </span>
                                        </div>
                                        <p
                                            :class="[
                                                'text-xs sm:text-sm leading-relaxed mt-1',
                                                currentTabObj.tab_theme === 'dark' ? 'text-slate-300' : 'text-slate-600'
                                            ]"
                                        >
                                            {{ item.description }}
                                        </p>
                                    </div>
                                </div>

                                <div
                                    v-if="!currentTabObj.items || !currentTabObj.items.length"
                                    :class="[
                                        'p-6 rounded-md border text-sm',
                                        currentTabObj.tab_theme === 'dark'
                                            ? 'bg-white/[0.04] border-white/10 text-slate-300'
                                            : 'bg-slate-50 border-slate-200 text-slate-600'
                                    ]"
                                >
                                    Adicione cards de diferenciais para esta Frente de Atuação no Painel Administrativo.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </section>
</template>
