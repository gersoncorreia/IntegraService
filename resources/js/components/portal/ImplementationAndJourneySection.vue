<script setup>
import { computed } from 'vue';
import AppIcon from '../ui/AppIcon.vue';

const props = defineProps({
    implementationSection: { type: Object, required: true },
});

const emit = defineEmits(['select-vertical']);

const extra = computed(() => props.implementationSection?.extra_data || {});
const steps = computed(() => props.implementationSection?.items || []);
</script>

<template>
    <section
        v-if="implementationSection"
        id="implantacao"
        class="py-14 sm:py-20 section-light-grid border-b border-slate-200/90 relative"
    >
        <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-8 sm:space-y-10">
            <!-- Cabeçalho da Seção de Implantação (Seção 6.4 do PDF) -->
            <div class="grid lg:grid-cols-12 gap-6 lg:gap-10 items-end" data-reveal>
                <div class="lg:col-span-7 space-y-3">
                    <div class="inline-flex items-center gap-2.5 pl-3 pr-3.5 py-1 bg-[#022B5B]/[0.06] border-l-2 border-[#00509D] rounded-r">
                        <span class="font-brand text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.14em] text-[#00509D]">
                            {{ implementationSection.badge_text || 'METODOLOGIA DE IMPLANTAÇÃO & JORNADA COMERCIAL' }}
                        </span>
                    </div>
                    <h2 class="font-brand text-2xl sm:text-4xl font-extrabold text-[#022B5B] leading-tight tracking-[-0.02em]">
                        {{ implementationSection.title || 'Uma implantação planejada para' }}
                        <span class="text-[#0077B6]">{{ implementationSection.highlighted_word || 'sua instituição' }}</span>
                    </h2>
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                        {{ implementationSection.subtitle }}
                    </p>
                </div>

                <div class="lg:col-span-5 flex lg:justify-end">
                    <button
                        type="button"
                        @click="emit('select-vertical', 'Gestão Cooperativista - SISCOOP3F')"
                        class="w-full sm:w-auto px-6 py-4 rounded-md font-brand font-bold text-xs uppercase tracking-[0.1em] text-white bg-[#022B5B] hover:bg-[#00509D] border-b-2 border-[#00E5FF] transition cursor-pointer text-center shadow-xs"
                    >
                        {{ implementationSection.primary_cta_text || 'Conheça nosso modelo de implantação' }} →
                    </button>
                </div>
            </div>

            <!-- Grade das 5 Etapas da Jornada Comercial Recomendada (Seção 5 do PDF) -->
            <div v-if="steps.length" class="space-y-3" data-reveal>
                <div class="flex items-center justify-between">
                    <span class="font-mono text-[11px] font-bold uppercase tracking-widest text-[#00509D]">
                        {{ extra.journey_title || 'Jornada Comercial Recomendada em 5 Etapas' }}
                    </span>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-3.5 sm:gap-4">
                    <div
                        v-for="(step, idx) in steps"
                        :key="step.id || idx"
                        class="exec-card rounded-md bg-white border border-slate-200 border-t-4 border-t-[#022B5B] p-4 sm:p-5 flex flex-col justify-between shadow-2xs"
                    >
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="font-mono text-[10px] font-bold px-2 py-0.5 rounded-xs bg-[#022B5B] text-[#00E5FF]">
                                    {{ step.badge || `ETAPA 0${idx + 1}` }}
                                </span>
                                <AppIcon :name="step.icon || 'shield-check'" class="w-4 h-4 text-[#0077B6]" />
                            </div>
                            <h3 class="font-brand font-extrabold text-sm sm:text-base text-[#022B5B] leading-snug">
                                {{ step.title }}
                            </h3>
                            <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">
                                {{ step.description }}
                            </p>
                        </div>

                        <div class="mt-4 pt-2.5 border-t border-slate-100 flex items-center justify-between text-[10px] font-mono text-slate-400">
                            <span>{{ step.subtitle || 'Acompanhamento Técnico' }}</span>
                            <span class="text-[#0077B6] font-bold">→</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nota de Transparência sobre Prazos, Escopo e Condições Comerciais -->
            <div class="p-4 sm:p-5 rounded-md bg-white border border-slate-200 border-l-4 border-l-[#0077B6] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-start gap-3">
                    <span class="w-5 h-5 rounded-xs bg-[#0077B6]/10 text-[#0077B6] flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">i</span>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        {{ extra.commercial_note || implementationSection.description || 'As etapas, os prazos e as condições comerciais serão definidos conforme a solução contratada e a complexidade da operação.' }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
