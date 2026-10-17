<script setup>
import { ref, computed, watch } from 'vue';
import BrandLogo from '../ui/BrandLogo.vue';
import AppIcon from '../ui/AppIcon.vue';

const props = defineProps({
    ecosystem: { type: Object, default: null },
    siscoop: { type: Object, default: null },
    telemedicine: { type: Object, default: null },
    clinic: { type: Object, default: null },
    departments: { type: Array, default: () => [] },
    consulting: { type: Object, default: null },
    book: { type: Object, default: null },
    featuredBook: { type: Object, default: null },
    settings: { type: Object, required: true },
    externalTab: { type: String, default: 'siscoop3f' },
});

const emit = defineEmits(['select-vertical']);

const activeTab = ref(props.externalTab || 'siscoop3f');
const activeDeptIdx = ref(0);
const deptDetailRef = ref(null);

watch(() => props.externalTab, (newTab) => {
    if (newTab) activeTab.value = newTab;
});

const selectDepartment = (idx) => {
    activeDeptIdx.value = idx;
    if (window.innerWidth < 1024 && deptDetailRef.value) {
        deptDetailRef.value.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
};

const currentDepartment = computed(() => props.departments[activeDeptIdx.value] || null);

const tabs = [
    { key: 'siscoop3f', number: '01', title: 'SISCOOP3F', sub: 'Gestão de Cooperativas', icon: 'network' },
    { key: 'telemedicine', number: '02', title: 'Telemedicina', sub: 'Saúde Digital 24/7', icon: 'video' },
    { key: 'clinic', number: '03', title: 'A Clínica', sub: '9 Departamentos', icon: 'heart-pulse' },
    { key: 'consulting', number: '04', title: 'Consultoria', sub: 'Auditoria & Mentoria', icon: 'chart-bar' },
    { key: 'book', number: '05', title: 'O Livro', sub: 'Base Científica', icon: 'book-open' },
];
</script>

<template>
    <section id="ecossistema" class="py-16 sm:py-24 section-light-grid border-b border-slate-200/80 relative">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <!-- Cabeçalho Editorial Estruturado -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 sm:gap-6 mb-8 sm:mb-10" data-reveal>
                <div>
                    <div class="inline-flex items-center gap-2.5 pl-3 pr-3.5 py-1 bg-[#022B5B]/[0.06] border-l-2 border-[#00509D] rounded-r mb-3">
                        <span class="font-brand text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.14em] text-[#00509D]">
                            {{ ecosystem?.badge_text || 'ARQUITETURA DE SOLUÇÕES' }}
                        </span>
                    </div>
                    <h2 class="font-brand text-2xl sm:text-4xl font-extrabold text-[#022B5B] leading-tight tracking-[-0.02em]">
                        {{ ecosystem?.title || 'Tudo o que sua instituição precisa em' }}
                        <span class="text-[#0077B6]">{{ ecosystem?.highlighted_word || 'um único ecossistema' }}</span>
                    </h2>
                </div>
                <p class="text-slate-600 text-sm sm:text-base max-w-md leading-relaxed">
                    {{ ecosystem?.subtitle || 'Toque em uma das 5 frentes de atuação abaixo para conhecer os diferenciais técnicos e operacionais de cada vertical.' }}
                </p>
            </div>

            <!-- Barra Arquitetônica de 5 Abas Numeradas (No mobile: 2+2+1 Full-Width Simétrico sem buraco vazio!) -->
            <div
                class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 bg-white border border-slate-200 rounded-t-lg shadow-xs overflow-hidden divide-y divide-x divide-slate-200"
                data-reveal
            >
                <button
                    v-for="(tab, index) in tabs"
                    :key="tab.key"
                    type="button"
                    @click="activeTab = tab.key"
                    :class="[
                        'group relative p-3.5 sm:p-5 text-left transition-all duration-200 cursor-pointer flex flex-col justify-between',
                        index === 4 ? 'col-span-2 sm:col-span-1' : '',
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
                            :name="tab.icon"
                            :class="[
                                'w-4 h-4 sm:w-5 sm:h-5 transition-colors',
                                activeTab === tab.key ? 'text-[#00E5FF]' : 'text-[#0077B6]'
                            ]"
                        />
                    </div>

                    <div>
                        <span class="font-brand font-extrabold text-xs sm:text-[15px] block tracking-tight">
                            {{ tab.title }}
                        </span>
                        <span
                            :class="[
                                'text-[11px] block mt-0.5 truncate',
                                activeTab === tab.key ? 'text-cyan-200' : 'text-slate-500'
                            ]"
                        >
                            {{ tab.sub }}
                        </span>
                    </div>
                </button>
            </div>

            <!-- Painel de Conteúdo Conectado à Barra de Abas -->
            <Transition name="fade-slide" mode="out-in">
                <!-- ABA 01: SISCOOP3F -->
                <div
                    v-if="activeTab === 'siscoop3f'"
                    key="tab-siscoop"
                    class="rounded-b-lg bg-white border-x border-b border-slate-200 p-5 sm:p-10 shadow-[0_16px_40px_rgba(2,43,91,0.05)]"
                >
                    <div class="grid lg:grid-cols-12 gap-7 lg:gap-12 items-start">
                        <!-- Coluna Esquerda: Contexto Executivo -->
                        <div class="lg:col-span-5 space-y-4 sm:space-y-5 lg:pr-4">
                            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xs bg-[#004E89]/10 text-[#004E89] font-brand font-bold text-[10px] sm:text-[11px] uppercase tracking-wider">
                                <span>01 • GESTÃO COOPERATIVISTA INTELIGENTE</span>
                            </div>

                            <h3 class="font-brand text-xl sm:text-3xl font-extrabold text-[#022B5B] tracking-tight leading-snug">
                                Plataforma SISCOOP3F
                            </h3>

                            <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                                {{ siscoop?.subtitle || 'A tecnologia deve gerar resultado antes de gerar custo. Implantamos o SISCOOP3F com 30 dias gratuitos de adaptação e remuneração baseada em eficiência.' }}
                            </p>

                            <div class="pt-1 sm:pt-2 flex flex-col sm:flex-row lg:flex-col xl:flex-row gap-2.5 sm:gap-3">
                                <a
                                    :href="settings.siscoop3f_url"
                                    target="_blank"
                                    rel="noopener"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider text-white bg-[#022B5B] hover:bg-[#00509D] border-b-2 border-[#00E5FF] transition"
                                >
                                    <span>Acessar siscoop3f.com.br</span>
                                    <span class="text-[#00E5FF]">↗</span>
                                </a>
                                <a
                                    href="#siscoop3f"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider text-[#022B5B] bg-slate-100 hover:bg-slate-200/80 border border-slate-200 transition"
                                >
                                    <span>Simulador Financeiro</span>
                                    <span>↓</span>
                                </a>
                            </div>
                        </div>

                        <!-- Coluna Direita: Lista Horizontal de Recursos -->
                        <div class="lg:col-span-7 space-y-3">
                            <div
                                v-for="(item, index) in (siscoop?.items || []).slice(0, 3)"
                                :key="item.id"
                                class="exec-card p-4 sm:p-5 rounded-md bg-[#F8FAFC] hover:bg-white border border-slate-200/90 border-l-4 border-l-[#00509D] flex items-start gap-3.5 sm:gap-4 shadow-2xs"
                            >
                                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded bg-[#022B5B] text-[#00E5FF] flex items-center justify-center shrink-0 mt-0.5">
                                    <AppIcon :name="item.icon" class="w-5 h-5" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center justify-between gap-1.5 sm:gap-2">
                                        <h4 class="font-brand font-bold text-sm sm:text-base text-[#022B5B]">
                                            {{ item.title }}
                                        </h4>
                                        <span class="px-2 py-0.5 rounded-xs bg-[#0077B6]/10 text-[#0077B6] font-brand font-bold text-[10px] uppercase tracking-wider">
                                            {{ item.highlight_metric || `Pilar 0${index + 1}` }}
                                        </span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mt-1">
                                        {{ item.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ABA 02: TELEMEDICINA -->
                <div
                    v-else-if="activeTab === 'telemedicine'"
                    key="tab-telemedicine"
                    class="rounded-b-lg bg-[#021B3A] text-white border-x border-b border-cyan-500/30 p-5 sm:p-10 shadow-xl"
                >
                    <div class="grid lg:grid-cols-12 gap-7 lg:gap-12 items-start">
                        <div class="lg:col-span-5 space-y-4 sm:space-y-5">
                            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xs bg-[#00F5D4]/15 text-[#00F5D4] font-brand font-bold text-[10px] sm:text-[11px] uppercase tracking-wider">
                                <span>02 • SAÚDE DIGITAL 24/7</span>
                            </div>

                            <h3 class="font-brand text-xl sm:text-3xl font-extrabold leading-snug">
                                {{ telemedicine?.title || 'Telemedicina Rápida e' }}
                                <span class="text-[#00F5D4]">{{ telemedicine?.highlighted_word || 'Sem Filas' }}</span>
                            </h3>

                            <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                                {{ telemedicine?.subtitle }}
                            </p>

                            <div class="pt-1 sm:pt-2 flex flex-col sm:flex-row flex-wrap gap-2.5 sm:gap-3">
                                <a
                                    :href="settings.telemedicine_url"
                                    target="_blank"
                                    rel="noopener"
                                    class="w-full sm:w-auto text-center px-5 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider text-[#01162E] bg-[#00F5D4] hover:bg-white transition"
                                >
                                    Acessar Portal de Telemedicina ↗
                                </a>
                                <button
                                    type="button"
                                    @click="emit('select-vertical', 'Plataforma de Telemedicina')"
                                    class="w-full sm:w-auto text-center px-5 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider text-white bg-white/10 hover:bg-white/15 border border-white/20 transition cursor-pointer"
                                >
                                    Solicitar Proposta Comercial
                                </button>
                            </div>
                        </div>

                        <div class="lg:col-span-7 space-y-3">
                            <div
                                v-for="item in (telemedicine?.items || [])"
                                :key="item.id"
                                class="exec-card p-4 sm:p-5 rounded-md bg-white/[0.05] hover:bg-white/[0.08] border border-white/10 border-l-4 border-l-[#00F5D4] flex items-start gap-3.5 sm:gap-4"
                            >
                                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded bg-[#00F5D4]/15 text-[#00F5D4] border border-[#00F5D4]/30 flex items-center justify-center shrink-0 mt-0.5">
                                    <AppIcon :name="item.icon" class="w-5 h-5" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center justify-between gap-1.5 sm:gap-2">
                                        <h4 class="font-brand font-bold text-sm sm:text-base text-white">
                                            {{ item.title }}
                                        </h4>
                                        <span class="px-2 py-0.5 rounded-xs bg-[#00F5D4]/15 text-[#00F5D4] font-brand font-bold text-[10px] uppercase tracking-wider">
                                            {{ item.highlight_metric }}
                                        </span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed mt-1">
                                        {{ item.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ABA 03: A CLÍNICA & DEPARTAMENTOS (Com Chips Horizontais Touch no Mobile!) -->
                <div
                    v-else-if="activeTab === 'clinic'"
                    key="tab-clinic"
                    class="rounded-b-lg bg-white border-x border-b border-slate-200 p-5 sm:p-10 shadow-[0_16px_40px_rgba(2,43,91,0.05)]"
                >
                    <div class="grid lg:grid-cols-12 gap-6 lg:gap-8 items-start">
                        <div class="lg:col-span-5 space-y-2.5">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-brand font-bold uppercase tracking-wider text-[#00509D]">
                                    Selecione o Departamento Clínico:
                                </span>
                                <span class="text-[11px] font-mono text-slate-400">{{ departments.length }} unidades</span>
                            </div>

                            <!-- No Celular (< lg): Barra Deslizável Horizontal (Chips) para não empurrar o card para baixo! -->
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

                            <!-- No Desktop (lg+): Lista Vertical Completa -->
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
                                    @click="emit('select-vertical', 'A Clínica & Departamentos')"
                                    class="w-full sm:w-auto px-6 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider text-white bg-[#022B5B] hover:bg-[#00509D] border-b-2 border-[#00E5FF] transition cursor-pointer"
                                >
                                    {{ currentDepartment.cta_text }} →
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ABA 04: CONSULTORIA, AUDITORIA & MENTORIA -->
                <div
                    v-else-if="activeTab === 'consulting'"
                    key="tab-consulting"
                    class="rounded-b-lg bg-white border-x border-b border-slate-200 p-5 sm:p-10 shadow-[0_16px_40px_rgba(2,43,91,0.05)]"
                >
                    <div class="grid lg:grid-cols-12 gap-7 lg:gap-12 items-start">
                        <div class="lg:col-span-5 space-y-4 sm:space-y-5">
                            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xs bg-[#022B5B]/10 text-[#022B5B] font-brand font-bold text-[10px] sm:text-[11px] uppercase tracking-wider">
                                <span>04 • INTELIGÊNCIA CORPORATIVA • {{ settings.consultant_name }}</span>
                            </div>

                            <h3 class="font-brand text-xl sm:text-3xl font-extrabold text-[#022B5B] leading-snug">
                                Consultoria, Auditoria & Mentoria Executiva
                            </h3>

                            <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                                {{ consulting?.subtitle }}
                            </p>

                            <button
                                type="button"
                                @click="emit('select-vertical', 'Consultoria, Auditoria & Mentoria')"
                                class="w-full sm:w-auto px-6 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider text-white bg-[#022B5B] hover:bg-[#00509D] border-b-2 border-[#00E5FF] transition cursor-pointer"
                            >
                                Agendar Diagnóstico com o Consultor →
                            </button>
                        </div>

                        <div class="lg:col-span-7 space-y-3">
                            <div
                                v-for="item in (consulting?.items || [])"
                                :key="item.id"
                                class="exec-card p-4 sm:p-5 rounded-md bg-[#F8FAFC] hover:bg-white border border-slate-200 border-l-4 border-l-[#022B5B] flex items-start gap-3.5 sm:gap-4"
                            >
                                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded bg-[#022B5B] text-[#00E5FF] flex items-center justify-center shrink-0 mt-0.5">
                                    <AppIcon :name="item.icon" class="w-5 h-5" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-wrap items-center justify-between gap-1.5 sm:gap-2">
                                        <h4 class="font-brand font-bold text-sm sm:text-base text-[#022B5B]">
                                            {{ item.title }}
                                        </h4>
                                        <span class="px-2 py-0.5 rounded-xs bg-[#022B5B]/10 text-[#022B5B] font-brand font-bold text-[10px] uppercase tracking-wider">
                                            {{ item.highlight_metric }}
                                        </span>
                                    </div>
                                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mt-1">
                                        {{ item.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ABA 05: O LIVRO & AUTORIDADE -->
                <div
                    v-else-if="activeTab === 'book'"
                    key="tab-book"
                    class="rounded-b-lg bg-[#01162E] text-white border-x border-b border-cyan-500/30 p-5 sm:p-10 shadow-xl"
                >
                    <div v-if="featuredBook" class="grid lg:grid-cols-12 gap-7 lg:gap-12 items-center">
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
                                <span>05 • AUTORIDADE CIENTÍFICA & INTELECTUAL</span>
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
                                    @click="emit('select-vertical', 'Livro & Publicações')"
                                    class="w-full sm:w-auto px-6 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider text-[#01162E] bg-[#00E5FF] hover:bg-[#80FFDB] transition cursor-pointer"
                                >
                                    {{ featuredBook.cta_text }} →
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </section>
</template>
