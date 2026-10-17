<script setup>
import { computed } from 'vue';
import AppIcon from '../ui/AppIcon.vue';

const props = defineProps({
    identitySection: { type: Object, required: true },
});

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
</script>

<template>
    <section
        v-if="identitySection"
        id="identidade"
        class="py-14 sm:py-20 bg-white border-b border-slate-200/90 relative"
    >
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <!-- Cabeçalho Enxuto e Executivo -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-7 sm:mb-9" data-reveal>
                <div>
                    <div class="inline-flex items-center gap-2.5 pl-3 pr-3.5 py-1 bg-[#022B5B]/[0.06] border-l-2 border-[#022B5B] rounded-r mb-2.5">
                        <span class="font-brand text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.14em] text-[#022B5B]">
                            {{ identitySection.badge_text || 'DIRETRIZES ESTRATÉGICAS • GOVERNANÇA & PROPÓSITO' }}
                        </span>
                    </div>
                    <h2 class="font-brand text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#022B5B] leading-tight tracking-[-0.02em]">
                        {{ identitySection.title || 'A base institucional que guia' }}
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

            <!-- Grade Arquitetônica Swiss-Grid Compacta (Sem poluir a página!) -->
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
        </div>
    </section>
</template>
