<script setup>
import { computed } from 'vue';
import AppIcon from '../ui/AppIcon.vue';

const props = defineProps({
    identitySection: { type: Object, required: true },
    settings: { type: Object, default: () => ({}) },
});

const emit = defineEmits(['select-vertical']);

const extra = computed(() => props.identitySection?.extra_data || {});

const purposeLabel = computed(() => extra.value.purpose_label || 'Razão de Existir');
const purposeText = computed(
    () =>
        extra.value.purpose_text ||
        'Integrar conhecimento, gestão, tecnologia e serviços especializados para ajudar pessoas e organizações a crescer, melhorar seus resultados e gerar valor sustentável.'
);

const missionLabel = computed(() => extra.value.mission_label || 'Missão');
const missionText = computed(
    () =>
        extra.value.mission_text ||
        'Desenvolver e integrar soluções empresariais, tecnológicas e de saúde por meio de conhecimento, inovação, consultoria e parcerias estratégicas, promovendo eficiência, acesso e sustentabilidade.'
);

const visionLabel = computed(() => extra.value.vision_label || 'Visão');
const visionText = computed(
    () =>
        extra.value.vision_text ||
        'Ser reconhecida como uma empresa de referência na integração de negócios, gestão digital, consultoria e soluções de saúde, com atuação regional e capacidade de expansão nacional.'
);

const valuesLabel = computed(() => extra.value.values_label || 'Valores Institucionais');
const valuesList = computed(() => {
    const raw =
        extra.value.values_text ||
        'Integridade, cooperação, inovação, transparência, excelência técnica, responsabilidade, segurança da informação, compromisso com resultados e valorização das pessoas.';

    return String(raw)
        .replace(/\.$/, '')
        .replace(/\s+e\s+/gi, ', ')
        .split(',')
        .map((item) => item.trim())
        .filter(Boolean)
        .map((item) => item.charAt(0).toUpperCase() + item.slice(1));
});

const leadershipBadge = computed(() => extra.value.leadership_badge || 'LIDERANÇA E RELACIONAMENTO INSTITUCIONAL');
const leadershipTitle = computed(() => extra.value.leadership_title || 'Eudemir Bezerra | Direção Executiva - IntegreService');
const leadershipBio1 = computed(
    () =>
        extra.value.leadership_bio_1 ||
        'À frente do relacionamento institucional e do desenvolvimento estratégico da IntegreService, Eudemir Bezerra atua na articulação de soluções e parcerias voltadas à gestão, tecnologia e inovação.'
);
const leadershipBio2 = computed(
    () =>
        extra.value.leadership_bio_2 ||
        'Sua atuação busca aproximar instituições de ferramentas e serviços que contribuam para a modernização administrativa, a eficiência operacional e a ampliação do acesso a soluções especializadas.'
);
const leadershipCtaText = computed(() => extra.value.leadership_cta_text || 'Falar com a direção executiva');
</script>

<template>
    <section
        v-if="identitySection"
        id="identidade"
        class="py-14 sm:py-20 bg-white border-b border-slate-200/90 relative"
    >
        <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-8 sm:space-y-10">
            <!-- Cabeçalho Enxuto e Executivo -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4" data-reveal>
                <div>
                    <div class="inline-flex items-center gap-2.5 pl-3 pr-3.5 py-1 bg-[#022B5B]/[0.06] border-l-2 border-[#022B5B] rounded-r mb-2.5">
                        <span class="font-brand text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.14em] text-[#022B5B]">
                            {{ identitySection.badge_text || 'QUEM SOMOS • IDENTIDADE E LIDERANÇA INSTITUCIONAL' }}
                        </span>
                    </div>
                    <h2 class="font-brand text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#022B5B] leading-tight tracking-[-0.02em]">
                        {{ identitySection.title || 'A base institucional e a liderança que guiam' }}
                        <span class="text-[#0077B6]">{{ identitySection.highlighted_word || 'nossa atuação' }}</span>
                    </h2>
                </div>
                <p
                    v-if="identitySection.subtitle"
                    class="text-slate-600 text-xs sm:text-sm max-w-md leading-relaxed"
                >
                    {{ identitySection.subtitle }}
                </p>
            </div>

            <!-- Grade Arquitetônica Swiss-Grid Compacta (Razão de Existir, Missão, Visão e Valores) -->
            <div
                class="rounded-lg border border-slate-200 bg-[#F8FAFC] shadow-[0_14px_36px_rgba(2,43,91,0.04)] overflow-hidden"
                data-reveal="scale"
            >
                <!-- 1. Faixa Superior de Destaque: RAZÃO DE EXISTIR -->
                <div class="bg-[#01162E] text-white p-5 sm:p-7 border-b border-cyan-500/25 relative overflow-hidden">
                    <div class="h-1 w-full absolute top-0 left-0 right-0 bg-gradient-to-r from-[#00509D] via-[#00E5FF] to-[#80FFDB]"></div>

                    <div class="grid lg:grid-cols-12 gap-4 lg:gap-8 items-center">
                        <div class="lg:col-span-3 flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-[#00E5FF]/15 border border-[#00E5FF]/30 text-[#00E5FF] flex items-center justify-center shrink-0">
                                <AppIcon name="sparkles" class="w-5 h-5" />
                            </div>
                            <div>
                                <span class="font-mono text-[10px] uppercase tracking-widest text-cyan-300 block">
                                    01 • PROPÓSITO CENTRAL
                                </span>
                                <h3 class="font-brand text-base sm:text-lg font-extrabold text-white tracking-tight">
                                    {{ purposeLabel }}
                                </h3>
                            </div>
                        </div>

                        <div class="lg:col-span-9 lg:border-l lg:border-white/15 lg:pl-8">
                            <p class="font-brand text-sm sm:text-base lg:text-[17px] font-semibold text-slate-100 leading-relaxed">
                                “{{ purposeText }}”
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 2. Células Simétricas: MISSÃO & VISÃO (Lado a Lado) -->
                <div class="grid md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-slate-200 bg-white">
                    <!-- Coluna Esquerda: Missão -->
                    <div class="p-5 sm:p-7 space-y-2.5">
                        <div class="flex items-center justify-between">
                            <div class="inline-flex items-center gap-2">
                                <span class="w-2 h-2 rounded-xs bg-[#00509D]"></span>
                                <span class="font-mono text-[10px] font-bold uppercase tracking-widest text-[#00509D]">
                                    02 • DIRETRIZ OPERACIONAL
                                </span>
                            </div>
                            <AppIcon name="shield-check" class="w-4 h-4 text-[#0077B6]" />
                        </div>

                        <h3 class="font-brand text-lg sm:text-xl font-extrabold text-[#022B5B]">
                            {{ missionLabel }}
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            {{ missionText }}
                        </p>
                    </div>

                    <!-- Coluna Direita: Visão -->
                    <div class="p-5 sm:p-7 space-y-2.5">
                        <div class="flex items-center justify-between">
                            <div class="inline-flex items-center gap-2">
                                <span class="w-2 h-2 rounded-xs bg-[#00B4D8]"></span>
                                <span class="font-mono text-[10px] font-bold uppercase tracking-widest text-[#0077B6]">
                                    03 • HORIZONTE DE EXPANSÃO
                                </span>
                            </div>
                            <AppIcon name="trending-up" class="w-4 h-4 text-[#00B4D8]" />
                        </div>

                        <h3 class="font-brand text-lg sm:text-xl font-extrabold text-[#022B5B]">
                            {{ visionLabel }}
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                            {{ visionText }}
                        </p>
                    </div>
                </div>

                <!-- 3. Rodapé Arquitetônico da Grade: VALORES EM PÍLULAS EXECUTIVAS -->
                <div class="p-5 sm:p-6 bg-[#F4F8FB] border-t border-slate-200">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3.5 sm:gap-5">
                        <div class="shrink-0">
                            <span class="font-mono text-[10px] font-bold uppercase tracking-widest text-[#00509D] block">
                                04 • ÉTICA & GOVERNANÇA
                            </span>
                            <h4 class="font-brand text-sm sm:text-base font-extrabold text-[#022B5B]">
                                {{ valuesLabel }}:
                            </h4>
                        </div>

                        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                            <span
                                v-for="(val, idx) in valuesList"
                                :key="idx"
                                class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded bg-white border border-slate-200/90 text-[#022B5B] font-brand font-bold text-[11px] sm:text-xs shadow-2xs"
                            >
                                <span class="w-1.5 h-1.5 rounded-xs bg-[#00B4D8]"></span>
                                <span>{{ val }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Bloco de Liderança e Relacionamento Institucional (Seção 6.5 do Diagnóstico Oficial) -->
            <div
                id="lideranca"
                class="rounded-lg border border-slate-200 border-l-4 border-l-[#022B5B] bg-white p-6 sm:p-8 shadow-2xs grid lg:grid-cols-12 gap-6 lg:gap-10 items-center"
                data-reveal
            >
                <div class="lg:col-span-8 space-y-3">
                    <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-xs bg-[#022B5B]/10 text-[#022B5B] font-brand font-bold text-[10px] sm:text-[11px] uppercase tracking-wider">
                        <AppIcon name="users" class="w-3.5 h-3.5 text-[#0077B6]" />
                        <span>{{ leadershipBadge }}</span>
                    </div>

                    <h3 class="font-brand text-xl sm:text-2xl font-extrabold text-[#022B5B] tracking-tight">
                        {{ leadershipTitle }}
                    </h3>

                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        {{ leadershipBio1 }}
                    </p>

                    <p v-if="leadershipBio2" class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        {{ leadershipBio2 }}
                    </p>
                </div>

                <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col items-stretch sm:items-center lg:items-end justify-between gap-3 pt-2 lg:pt-0 border-t lg:border-t-0 lg:border-l border-slate-200 lg:pl-8">
                    <div class="text-left lg:text-right">
                        <span class="font-mono text-[10px] uppercase tracking-widest text-slate-400 block">
                            ATENDIMENTO INSTITUCIONAL
                        </span>
                        <strong class="font-brand text-sm font-bold text-[#022B5B] block mt-0.5">
                            {{ settings?.company_city || 'Rio Branco - Acre' }}
                        </strong>
                        <span class="text-xs text-slate-500 block">
                            {{ settings?.contact_email || 'contato@integreservice.com.br' }}
                        </span>
                    </div>

                    <button
                        type="button"
                        @click="emit('select-vertical', 'Consultoria Executiva')"
                        class="w-full sm:w-auto px-5 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider text-white bg-[#022B5B] hover:bg-[#00509D] border-b-2 border-[#00E5FF] transition cursor-pointer text-center"
                    >
                        {{ leadershipCtaText }} →
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>
