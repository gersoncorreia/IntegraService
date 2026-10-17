<script setup>
import { ref, computed } from 'vue';
import BrandLogo from '../ui/BrandLogo.vue';
import AppIcon from '../ui/AppIcon.vue';
import { useScrollAndSpotlight } from '../../composables/useScrollAndSpotlight';

const props = defineProps({
    telemedicine: { type: Object, default: null },
    clinic: { type: Object, default: null },
    departments: { type: Array, default: () => [] },
    settings: { type: Object, required: true },
});

const emit = defineEmits(['select-vertical']);
const { handleCardMouseMove } = useScrollAndSpotlight();

const activeDeptIndex = ref(0);
const currentDepartment = computed(() => props.departments[activeDeptIndex.value] || null);
</script>

<template>
    <div>
        <!-- SEÇÃO 5: TELEMEDICINA (PALETA 02 - MARINHO & TURQUESA) -->
        <section v-if="telemedicine" id="telemedicina" class="py-24 bg-gradient-to-br from-[#F0FDFA] via-[#F4F8FB] to-[#E0F7FA] relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-5 order-2 lg:order-1 reveal-scale">
                        <div class="rounded-3xl bg-gradient-to-br from-[#03045E] via-[#004E89] to-[#0077B6] text-white p-8 shadow-[0_25px_60px_-15px_rgba(3,4,94,0.35)] border border-[#00F5D4]/40 relative overflow-hidden">
                            <div class="absolute -top-20 -right-20 w-56 h-56 rounded-full bg-[#00F5D4]/20 blur-3xl"></div>

                            <div class="flex items-center justify-between pb-6 mb-6 border-b border-white/15">
                                <BrandLogo
                                    :part1="settings.brand_part_1"
                                    :part2="settings.brand_part_2"
                                    tagline="Saúde Digital & Telemedicina"
                                    :logoPath="settings.logo_path"
                                    theme="dark"
                                    size="sm"
                                    :href="settings.telemedicine_url"
                                />
                                <span class="px-3 py-1 rounded-full text-[11px] font-brand font-bold bg-[#00F5D4]/20 text-[#00F5D4] border border-[#00F5D4]/40">
                                    Paleta 02 • Vitalidade
                                </span>
                            </div>

                            <h3 class="font-brand text-2xl font-extrabold text-white">
                                Portal de Atendimento Médico Remoto
                            </h3>
                            <p class="text-sm text-cyan-100 mt-2 leading-relaxed">
                                Acesse diretamente o ambiente seguro de Telemedicina para realizar consultas, emitir ou consultar prescrições e acompanhar pacientes.
                            </p>

                            <div class="my-6 p-4 rounded-2xl bg-white/10 border border-white/15 space-y-2.5 text-xs">
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-300">Ambiente Oficial:</span>
                                    <span class="font-mono text-[#00F5D4] font-semibold">app.consulttelemedicia.com.br</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-slate-300">Disponibilidade:</span>
                                    <span class="text-white font-semibold">Web & Mobile Responsivo</span>
                                </div>
                            </div>

                            <a
                                :href="telemedicine.primary_cta_url || settings.telemedicine_url"
                                target="_blank" rel="noopener"
                                class="w-full inline-flex items-center justify-center gap-3 py-4 px-6 rounded-2xl font-brand font-bold text-xs uppercase tracking-wider text-[#03045E] bg-gradient-to-r from-[#00F5D4] to-[#00BBF9] hover:shadow-[0_0_30px_rgba(0,245,212,0.5)] transition-all"
                            >
                                <span>{{ telemedicine.primary_cta_text }}</span>
                                <span>↗</span>
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-7 order-1 lg:order-2 space-y-6 reveal-up">
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#03045E]/10 text-[#03045E] font-brand font-bold text-xs uppercase tracking-widest">
                            <span class="w-2 h-2 rounded-full bg-[#00BBF9]"></span>
                            {{ telemedicine.badge_text }}
                        </span>

                        <h2 class="font-brand text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-[#03045E] leading-tight">
                            {{ telemedicine.title }}
                            <span class="text-[#0077B6]">{{ telemedicine.highlighted_word }}</span>
                        </h2>

                        <p class="text-slate-600 text-base sm:text-lg leading-relaxed">
                            {{ telemedicine.subtitle }}
                        </p>

                        <div class="grid sm:grid-cols-3 gap-4 pt-2">
                            <div
                                v-for="item in telemedicine.items"
                                :key="item.id"
                                @mousemove="handleCardMouseMove"
                                class="premium-card rounded-2xl bg-white p-5 border border-cyan-500/20 shadow-sm"
                            >
                                <div class="w-10 h-10 rounded-xl bg-[#00BBF9]/15 text-[#0077B6] flex items-center justify-center mb-3">
                                    <AppIcon :name="item.icon" class="w-5 h-5" />
                                </div>
                                <span class="text-[10px] font-brand font-bold uppercase tracking-wider text-[#0077B6]">{{ item.badge }}</span>
                                <h4 class="font-brand font-bold text-base text-[#03045E] mt-1">{{ item.title }}</h4>
                                <p class="text-xs text-slate-600 mt-2 leading-relaxed">{{ item.description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SEÇÃO 6: A CLÍNICA & DEPARTAMENTOS COM <Transition> VUE -->
        <section v-if="clinic && departments.length" id="clinica" class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-14 reveal-up">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#0077B6]/10 text-[#0077B6] font-brand font-bold text-xs uppercase tracking-widest">
                        <span class="w-2 h-2 rounded-full bg-[#00F5D4]"></span>
                        {{ clinic.badge_text }}
                    </span>
                    <h2 class="font-brand text-3xl sm:text-4xl lg:text-[42px] font-extrabold text-[#022B5B] mt-4 leading-tight">
                        {{ clinic.title }}
                        <span class="text-[#00B4D8]">{{ clinic.highlighted_word }}</span>
                    </h2>
                    <p class="text-slate-600 text-base sm:text-lg mt-4 leading-relaxed">
                        {{ clinic.subtitle }}
                    </p>
                </div>

                <div class="grid lg:grid-cols-12 gap-8 items-start">
                    <!-- Botões dos Departamentos -->
                    <div class="lg:col-span-5 space-y-3 reveal-up">
                        <button
                            v-for="(dept, idx) in departments"
                            :key="dept.id"
                            type="button"
                            @click="activeDeptIndex = idx"
                            :class="[
                                'w-full text-left p-5 rounded-2xl border transition-all duration-300 flex items-center justify-between gap-4 cursor-pointer',
                                activeDeptIndex === idx
                                    ? 'bg-gradient-to-r from-[#022B5B] to-[#00509D] text-white shadow-lg border-transparent scale-[1.01]'
                                    : 'bg-[#F4F8FB] hover:bg-sky-50/80 text-[#022B5B] border-slate-200/80'
                            ]"
                        >
                            <div class="flex items-center gap-4">
                                <div
                                    :class="[
                                        'w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-colors',
                                        activeDeptIndex === idx ? 'bg-[#00E5FF]/20 text-[#00E5FF]' : 'bg-white text-[#0077B6] shadow-sm'
                                    ]"
                                >
                                    <AppIcon :name="dept.icon" class="w-6 h-6" />
                                </div>
                                <div>
                                    <span
                                        :class="[
                                            'text-[10px] font-brand font-bold uppercase tracking-widest block',
                                            activeDeptIndex === idx ? 'text-cyan-300' : 'text-[#0077B6]'
                                        ]"
                                    >
                                        {{ dept.badge || 'DEPARTAMENTO ESPECIALIZADO' }}
                                    </span>
                                    <h3 class="font-brand font-bold text-base sm:text-lg leading-snug mt-0.5">
                                        {{ dept.name }}
                                    </h3>
                                </div>
                            </div>
                            <span class="opacity-75">→</span>
                        </button>
                    </div>

                    <!-- Painel Reativo do Departamento com <Transition mode="out-in"> -->
                    <div class="lg:col-span-7 reveal-scale">
                        <Transition name="fade-slide" mode="out-in">
                            <div
                                v-if="currentDepartment"
                                :key="currentDepartment.id"
                                class="rounded-3xl bg-[#F4F8FB] border border-slate-200/90 p-7 sm:p-10 shadow-sm"
                            >
                                <div class="flex flex-wrap items-center justify-between gap-4 pb-6 mb-6 border-b border-slate-200">
                                    <BrandLogo
                                        :part1="settings.brand_part_1"
                                        :part2="settings.brand_part_2"
                                        :tagline="currentDepartment.custom_tagline"
                                        :logoPath="settings.logo_path"
                                        theme="turquoise"
                                        size="md"
                                        href="#contato"
                                    />
                                    <span class="px-3 py-1 rounded-full text-xs font-brand font-bold bg-[#0077B6]/10 text-[#0077B6]">
                                        Assinatura Dinâmica da Sub-marca
                                    </span>
                                </div>

                                <h3 class="font-brand text-2xl sm:text-3xl font-extrabold text-[#022B5B]">
                                    {{ currentDepartment.name }}
                                </h3>
                                <p class="text-slate-700 font-medium mt-3 leading-relaxed">
                                    {{ currentDepartment.short_description }}
                                </p>
                                <p v-if="currentDepartment.full_description" class="text-sm text-slate-600 mt-3 leading-relaxed">
                                    {{ currentDepartment.full_description }}
                                </p>

                                <div v-if="currentDepartment.features?.length" class="mt-6 space-y-2.5">
                                    <h4 class="font-brand text-xs font-bold uppercase tracking-wider text-[#0077B6]">
                                        Diferenciais e Serviços Integrados:
                                    </h4>
                                    <div class="grid sm:grid-cols-2 gap-3 pt-1">
                                        <div
                                            v-for="(feat, fIdx) in currentDepartment.features"
                                            :key="fIdx"
                                            class="flex items-start gap-2.5 p-3 rounded-xl bg-white border border-slate-200/70 text-xs sm:text-sm text-slate-700"
                                        >
                                            <span class="w-5 h-5 rounded-full bg-[#00B4D8]/15 text-[#0077B6] flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">✓</span>
                                            <span>{{ feat }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-8 pt-6 border-t border-slate-200 flex flex-wrap items-center gap-4">
                                    <button
                                        type="button"
                                        @click="emit('select-vertical', 'A Clínica & Departamentos')"
                                        class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl font-brand font-bold text-xs uppercase tracking-wider text-white bg-gradient-to-r from-[#022B5B] via-[#00509D] to-[#00B4D8] hover:shadow-lg transition cursor-pointer"
                                    >
                                        <span>{{ currentDepartment.cta_text }}</span>
                                        <span>→</span>
                                    </button>
                                    <a :href="settings.telemedicine_url" target="_blank" class="text-xs font-brand font-bold uppercase tracking-wider text-[#0077B6] hover:text-[#022B5B]">
                                        Ou Iniciar Teleconsulta Agora →
                                    </a>
                                </div>
                            </div>
                        </Transition>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
