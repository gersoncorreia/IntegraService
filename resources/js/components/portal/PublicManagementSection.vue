<script setup>
import { computed } from 'vue';
import AppIcon from '../ui/AppIcon.vue';

const props = defineProps({
    publicSection: { type: Object, required: true },
});

const emit = defineEmits(['select-vertical']);

const extra = computed(() => props.publicSection?.extra_data || {});
const applications = computed(() => props.publicSection?.items || []);
</script>

<template>
    <section
        v-if="publicSection"
        id="gestao-publica"
        class="py-16 sm:py-24 bg-white border-b border-slate-200/90 relative"
    >
        <div class="max-w-6xl mx-auto px-4 sm:px-6 space-y-8 sm:space-y-12">
            <!-- Cabeçalho Executivo para Gestão Pública (Seção 6.6 do PDF) -->
            <div class="grid lg:grid-cols-12 gap-6 lg:gap-12 items-start" data-reveal>
                <div class="lg:col-span-7 space-y-3.5">
                    <div class="inline-flex items-center gap-2.5 pl-3 pr-3.5 py-1 bg-[#022B5B]/[0.06] border-l-2 border-[#022B5B] rounded-r">
                        <span class="font-brand text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.14em] text-[#022B5B]">
                            {{ publicSection.badge_text || 'SETOR PÚBLICO & MUNICÍPIOS • CONFORMIDADE E EFICIÊNCIA' }}
                        </span>
                    </div>

                    <h2 class="font-brand text-2xl sm:text-4xl font-extrabold text-[#022B5B] leading-tight tracking-[-0.02em]">
                        {{ publicSection.title || 'Soluções para a Gestão Pública: Tecnologia para apoiar a' }}
                        <span class="text-[#0077B6]">{{ publicSection.highlighted_word || 'modernização dos serviços públicos' }}</span>
                    </h2>

                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                        {{ publicSection.subtitle }}
                    </p>
                </div>

                <!-- Card de Conformidade e Contratação Pública -->
                <div class="lg:col-span-5 rounded-lg bg-[#01162E] text-white p-6 sm:p-7 border border-cyan-500/30 shadow-lg space-y-4">
                    <div class="flex items-center justify-between border-b border-white/10 pb-3">
                        <span class="font-mono text-[10px] font-bold uppercase tracking-widest text-[#00E5FF]">
                            GOVERNANÇA & REQUISITOS REGULATÓRIOS
                        </span>
                        <AppIcon name="shield-check" class="w-5 h-5 text-[#80FFDB]" />
                    </div>

                    <p class="text-xs sm:text-sm text-slate-200 leading-relaxed">
                        {{ extra.regulatory_note || publicSection.description || 'Cada projeto é estruturado conforme as necessidades do órgão, a viabilidade técnica, os requisitos regulatórios e as normas de contratação pública aplicáveis.' }}
                    </p>

                    <button
                        type="button"
                        @click="emit('select-vertical', 'Soluções para Gestão Pública')"
                        class="w-full py-3.5 px-5 rounded font-brand font-bold text-xs uppercase tracking-wider text-[#01162E] bg-[#00E5FF] hover:bg-[#80FFDB] transition cursor-pointer text-center shadow-sm"
                    >
                        {{ publicSection.primary_cta_text || 'Solicitar apresentação para gestão pública' }} →
                    </button>
                </div>
            </div>

            <!-- Grade das 5 Possibilidades de Aplicação no Setor Público -->
            <div v-if="applications.length" class="space-y-3" data-reveal>
                <span class="font-mono text-[11px] font-bold uppercase tracking-widest text-[#00509D] block">
                    Possibilidades de Aplicação em Municípios e Instituições Públicas:
                </span>

                <div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div
                        v-for="(app, idx) in applications"
                        :key="app.id || idx"
                        class="exec-card rounded-md bg-[#F8FAFC] hover:bg-white border border-slate-200 border-t-4 border-t-[#00509D] p-5 flex flex-col justify-between shadow-2xs"
                    >
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="font-mono text-[10px] font-bold px-2 py-0.5 rounded-xs bg-[#00509D]/10 text-[#00509D]">
                                    0{{ idx + 1 }}
                                </span>
                                <AppIcon :name="app.icon || 'cpu'" class="w-4 h-4 text-[#0077B6]" />
                            </div>

                            <h3 class="font-brand font-extrabold text-sm sm:text-base text-[#022B5B] leading-snug">
                                {{ app.title }}
                            </h3>

                            <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                                {{ app.description }}
                            </p>
                        </div>

                        <div class="mt-4 pt-2.5 border-t border-slate-200/70 flex items-center justify-between text-[10px] font-mono text-[#0077B6] font-bold">
                            <span>{{ app.highlight_metric || 'Setor Público' }}</span>
                            <span>✓</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
