<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    siscoop: { type: Object, default: null },
    investment: { type: Object, default: null },
    settings: { type: Object, required: true },
});

const emit = defineEmits(['select-vertical']);

const usersCount = ref(1500);
const monthlyWasteSavings = ref(50000);
const showCalculationMemory = ref(true);

const regularPrice = computed(() => Number(props.settings.sim_user_regular_price || 20));
const partnerPrice = computed(() => Number(props.settings.sim_user_partner_price || 10));
const savingsSharePercent = computed(() => Number(props.settings.sim_savings_share_percent || 30));
const coopRetentionPercent = computed(() => 100 - savingsSharePercent.value);

const netCooperativeMonthlyGain = computed(() => {
    return monthlyWasteSavings.value * (coopRetentionPercent.value / 100);
});

const integrePerformanceShareMonthly = computed(() => {
    return monthlyWasteSavings.value * (savingsSharePercent.value / 100);
});

const unitDiscountValue = computed(() => Math.max(0, regularPrice.value - partnerPrice.value));

const userDiscountTotalMonthly = computed(() => {
    return usersCount.value * unitDiscountValue.value;
});

const extra = computed(() => props.investment?.extra_data || {});

const formatBRL = (val) => {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        maximumFractionDigits: 0,
    }).format(val);
};
</script>

<template>
    <section
        v-if="investment || siscoop"
        id="siscoop3f"
        class="py-16 sm:py-24 section-dark-siscoop text-white relative overflow-hidden border-b border-cyan-500/20"
    >
        <div id="investimento" class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">
            <!-- Cabeçalho Editorial do Simulador e Modelo de Eficiência (Seção 6.3 do PDF) -->
            <div class="max-w-3xl mb-10 sm:mb-12" data-reveal>
                <div class="inline-flex items-center gap-2.5 pl-3 pr-4 py-1 bg-white/[0.06] border-l-2 border-[#80FFDB] rounded-r mb-3">
                    <span class="font-brand text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.14em] text-[#80FFDB]">
                        {{ investment?.badge_text || 'SIMULADOR DE EFICIÊNCIA & MODELO DE PARCERIA' }}
                    </span>
                </div>
                <h2 class="font-brand text-2xl sm:text-4xl font-extrabold leading-tight tracking-[-0.02em]">
                    {{ investment?.title || 'Simule o potencial de eficiência da' }}
                    <span class="text-[#80FFDB]">{{ investment?.highlighted_word || 'sua cooperativa' }}</span>
                </h2>
                <p class="text-slate-300 text-sm sm:text-base mt-2.5 sm:mt-3 leading-relaxed">
                    {{ investment?.subtitle || 'Descubra oportunidades de otimização de custos e melhoria de resultados.' }}
                </p>
            </div>

            <!-- As 3 Premissas Operacionais (Sem afirmações de "Risco Zero") -->
            <div v-if="investment?.items?.length" class="grid md:grid-cols-3 gap-4 sm:gap-6 mb-10 sm:mb-14">
                <div
                    v-for="(rule, idx) in investment.items.slice(0, 3)"
                    :key="rule.id"
                    :class="['exec-card rounded-md bg-[#01162E]/90 border border-white/12 border-t-2 border-t-[#80FFDB] p-5 sm:p-7 flex flex-col justify-between shadow-lg', `reveal-delay-${idx + 1}`]"
                    data-reveal
                >
                    <div>
                        <div class="flex flex-wrap items-baseline justify-between gap-2 pb-3.5 sm:pb-4 mb-3.5 sm:mb-4 border-b border-white/10">
                            <span class="font-brand text-2xl sm:text-3xl font-black text-[#80FFDB] tracking-tight">
                                {{ rule.highlight_metric }}
                            </span>
                            <span class="font-mono text-[10px] sm:text-[11px] font-bold uppercase tracking-widest text-cyan-300 bg-white/[0.06] px-2.5 py-1 rounded-xs">
                                {{ rule.badge || `PREMISSA 0${idx + 1}` }}
                            </span>
                        </div>

                        <h3 class="font-brand text-base sm:text-lg font-extrabold text-white leading-snug">
                            {{ rule.title }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-300 mt-2 leading-relaxed">
                            {{ rule.description }}
                        </p>
                    </div>

                    <div class="mt-4 sm:mt-5 pt-3 border-t border-white/[0.06] flex items-center justify-between text-[10px] sm:text-[11px] text-slate-400 font-mono">
                        <span>PREMISSA AUDITÁVEL</span>
                        <span class="text-[#80FFDB]">SOB APURAÇÃO</span>
                    </div>
                </div>
            </div>

            <!-- Painel Simulador Financeiro com Memória de Cálculo Transparente -->
            <div
                class="rounded-lg bg-[#010E1F] border border-cyan-400/25 shadow-[0_24px_60px_rgba(0,0,0,0.45)] overflow-hidden"
                data-reveal="scale"
            >
                <!-- Barra Superior de Status do Simulador -->
                <div class="px-5 sm:px-9 py-3.5 sm:py-4 bg-white/[0.03] border-b border-white/10 flex flex-wrap items-center justify-between gap-2 sm:gap-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-xs bg-[#00E5FF] shrink-0"></span>
                        <span class="font-brand text-[11px] sm:text-xs font-bold uppercase tracking-[0.12em] sm:tracking-[0.14em] text-[#00E5FF]">
                            Simulador Preliminar de Eficiência Operacional (SISCOOP3F)
                        </span>
                    </div>
                    <span class="text-[10px] sm:text-xs text-amber-300 font-mono">
                        PROJEÇÃO ILUSTRATIVA • SUJEITA A DIAGNÓSTICO
                    </span>
                </div>

                <div class="p-5 sm:p-9 space-y-6 sm:space-y-8">
                    <div class="grid lg:grid-cols-12 gap-7 lg:gap-10 items-start">
                        <!-- Coluna Esquerda: Controles Deslizantes Touch-Friendly (6 Colunas) -->
                        <div class="lg:col-span-6 space-y-5 sm:space-y-6">
                            <div>
                                <h3 class="font-brand text-xl sm:text-2xl font-extrabold text-white tracking-tight">
                                    {{ extra.simulator_title || 'Simule o potencial de eficiência da sua cooperativa' }}
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-300 mt-1.5 leading-relaxed">
                                    {{ extra.simulator_subtitle || 'Utilize nosso simulador para construir uma estimativa preliminar dos possíveis impactos financeiros da modernização dos processos administrativos e operacionais da sua cooperativa.' }}
                                </p>
                            </div>

                            <!-- Slider 1: Usuários -->
                            <div class="p-4 sm:p-5 rounded-md bg-white/[0.04] border border-white/10 space-y-3">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="text-xs sm:text-sm font-brand font-semibold text-slate-200">
                                        1. Base Estimada de Usuários Vinculados
                                    </span>
                                    <span class="px-2.5 py-1 rounded-xs bg-[#00E5FF]/15 text-[#00E5FF] font-brand font-extrabold text-xs sm:text-sm">
                                        {{ usersCount.toLocaleString('pt-BR') }} usuários
                                    </span>
                                </div>
                                <input
                                    type="range"
                                    min="200"
                                    max="15000"
                                    step="100"
                                    v-model.number="usersCount"
                                    class="w-full exec-range"
                                >
                                <div class="flex justify-between text-[10px] sm:text-[11px] font-mono text-slate-400">
                                    <span>200</span>
                                    <span>7.500</span>
                                    <span>15.000 usuários</span>
                                </div>
                            </div>

                            <!-- Slider 2: Economia Operacional Bruta Estimada -->
                            <div class="p-4 sm:p-5 rounded-md bg-white/[0.04] border border-white/10 space-y-3">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="text-xs sm:text-sm font-brand font-semibold text-slate-200">
                                        2. Economia Operacional Bruta Estimada
                                    </span>
                                    <span class="px-2.5 py-1 rounded-xs bg-[#80FFDB]/15 text-[#80FFDB] font-brand font-extrabold text-xs sm:text-sm">
                                        {{ formatBRL(monthlyWasteSavings) }}/mês
                                    </span>
                                </div>
                                <input
                                    type="range"
                                    min="5000"
                                    max="200000"
                                    step="5000"
                                    v-model.number="monthlyWasteSavings"
                                    class="w-full exec-range"
                                >
                                <div class="flex justify-between text-[10px] sm:text-[11px] font-mono text-slate-400">
                                    <span>R$ 5 mil</span>
                                    <span>R$ 100 mil</span>
                                    <span>R$ 200 mil/mês</span>
                                </div>
                            </div>
                        </div>

                        <!-- Coluna Direita: Painel de Resultados Separados por Natureza (6 Colunas) -->
                        <div class="lg:col-span-6 space-y-3.5 sm:space-y-4">
                            <!-- Card 1: Economia Operacional Líquida Retida na Cooperativa -->
                            <div class="p-4 sm:p-6 rounded-md bg-emerald-500/[0.08] border border-emerald-400/30 border-l-4 border-l-[#80FFDB] flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
                                <div>
                                    <span class="text-[10px] sm:text-[11px] font-brand font-bold uppercase tracking-wider text-emerald-300 block">
                                        A) Economia Operacional Retida na Cooperativa ({{ coopRetentionPercent }}%)
                                    </span>
                                    <div class="font-brand text-2xl sm:text-3xl font-black text-[#80FFDB] mt-1 tracking-tight">
                                        {{ formatBRL(netCooperativeMonthlyGain) }}<span class="text-sm sm:text-base font-bold text-emerald-200">/mês</span>
                                    </div>
                                    <span class="text-[11px] text-slate-300 block mt-0.5">
                                        Participação IntegreService ({{ savingsSharePercent }}%): {{ formatBRL(integrePerformanceShareMonthly) }}/mês
                                    </span>
                                </div>
                                <div class="sm:text-right pt-2.5 sm:pt-0 border-t sm:border-t-0 border-white/10 flex sm:block items-center justify-between">
                                    <span class="text-[11px] text-slate-300 block">Projeção em 12 Meses</span>
                                    <strong class="font-brand text-sm sm:text-base font-extrabold text-white">
                                        {{ formatBRL(netCooperativeMonthlyGain * 12) }}/ano
                                    </strong>
                                </div>
                            </div>

                            <!-- 2 Cards Secundários: Avaliacão Assistida vs Desconto na Assinatura Digital -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                                <div class="p-4 sm:p-5 rounded-md bg-white/[0.04] border border-white/10">
                                    <span class="text-[10px] sm:text-[11px] font-brand font-bold uppercase tracking-wider text-slate-300 block">
                                        B) Período Inicial SISCOOP3F
                                    </span>
                                    <strong class="font-brand text-xl sm:text-2xl font-black text-white mt-1 block tracking-tight">
                                        {{ settings.sim_trial_days }} Dias*
                                    </strong>
                                    <span class="text-xs text-emerald-300 mt-1 block font-medium">
                                        Avaliação assistida conforme escopo contratual
                                    </span>
                                </div>

                                <div class="p-4 sm:p-5 rounded-md bg-[#00509D]/25 border border-cyan-400/30">
                                    <span class="text-[10px] sm:text-[11px] font-brand font-bold uppercase tracking-wider text-cyan-200 block">
                                        C) Desconto Potencial na Tarifa Digital
                                    </span>
                                    <strong class="font-brand text-xl sm:text-2xl font-black text-[#00E5FF] mt-1 block tracking-tight">
                                        {{ formatBRL(userDiscountTotalMonthly) }}<span class="text-xs sm:text-sm font-bold">/mês</span>
                                    </strong>
                                    <span class="text-xs text-slate-300 mt-1 block">
                                        De R$ {{ regularPrice.toFixed(0) }} por R$ {{ partnerPrice.toFixed(0) }}/usuário (-R$ {{ unitDiscountValue.toFixed(0) }})
                                    </span>
                                </div>
                            </div>

                            <!-- Botões de Ação do Simulador (Seção 6.3 do PDF) -->
                            <div class="pt-1 sm:pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3">
                                <button
                                    type="button"
                                    @click="emit('select-vertical', 'Gestão Cooperativista - SISCOOP3F', usersCount)"
                                    class="flex-1 py-4 px-4 sm:px-5 rounded font-brand font-bold text-xs uppercase tracking-wider text-[#01162E] bg-[#00E5FF] hover:bg-[#80FFDB] transition text-center cursor-pointer shadow-md"
                                >
                                    {{ extra.simulator_cta_text || 'Solicitar análise personalizada' }} →
                                </button>
                                <button
                                    type="button"
                                    @click="showCalculationMemory = !showCalculationMemory"
                                    class="py-3.5 sm:py-4 px-4 rounded font-brand font-bold text-xs uppercase tracking-wider text-cyan-200 bg-white/[0.06] hover:bg-white/[0.12] border border-white/15 transition text-center whitespace-nowrap cursor-pointer"
                                >
                                    {{ showCalculationMemory ? 'Ocultar Memória' : 'Ver Memória de Cálculo' }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Quadro de Memória de Cálculo Visível e Ressalva Legal (Seção 4 e 6.3 do PDF) -->
                    <div
                        v-if="showCalculationMemory"
                        class="rounded-md bg-white/[0.03] border border-white/12 p-4 sm:p-6 space-y-4"
                    >
                        <div class="flex flex-wrap items-center justify-between gap-2 pb-3 border-b border-white/10">
                            <span class="font-mono text-[11px] font-bold uppercase tracking-widest text-[#00E5FF]">
                                Memória de Cálculo Transparente & Metodologia da Estimativa
                            </span>
                            <span class="font-mono text-[11px] text-slate-400">
                                Valores meramente exemplificativos
                            </span>
                        </div>

                        <div class="grid md:grid-cols-3 gap-4 text-xs">
                            <div class="p-3.5 rounded bg-white/[0.03] border border-white/10 space-y-1">
                                <strong class="font-brand text-white block">1. Economia Operacional (Item A)</strong>
                                <p class="text-slate-300 leading-relaxed font-mono text-[11px]">
                                    {{ formatBRL(monthlyWasteSavings) }} × {{ coopRetentionPercent }}% = {{ formatBRL(netCooperativeMonthlyGain) }}/mês
                                </p>
                                <p class="text-slate-400 text-[11px]">
                                    Corresponde à fração retida pela cooperativa sobre reduções de custos operacionais comprovadamente apuradas após implantação.
                                </p>
                            </div>

                            <div class="p-3.5 rounded bg-white/[0.03] border border-white/10 space-y-1">
                                <strong class="font-brand text-white block">2. Impacto Anualizado Estimado</strong>
                                <p class="text-slate-300 leading-relaxed font-mono text-[11px]">
                                    {{ formatBRL(netCooperativeMonthlyGain) }} × 12 meses = {{ formatBRL(netCooperativeMonthlyGain * 12) }}/ano
                                </p>
                                <p class="text-slate-400 text-[11px]">
                                    Projeção linear de 12 meses mantendo-se constante a economia operacional mensal estimada no controle deslizante.
                                </p>
                            </div>

                            <div class="p-3.5 rounded bg-white/[0.03] border border-white/10 space-y-1">
                                <strong class="font-brand text-white block">3. Desconto Potencial na Tarifa (Item C)</strong>
                                <p class="text-slate-300 leading-relaxed font-mono text-[11px]">
                                    {{ usersCount.toLocaleString('pt-BR') }} usuários × (R$ {{ regularPrice }} - R$ {{ partnerPrice }}) = {{ formatBRL(userDiscountTotalMonthly) }}/mês
                                </p>
                                <p class="text-slate-400 text-[11px]">
                                    Diferença entre a tarifa referencial individual (R$ {{ regularPrice }}/mês) e a tarifa de parceria institucional (R$ {{ partnerPrice }}/mês). Não se confunde com a economia operacional do Item A.
                                </p>
                            </div>
                        </div>

                        <!-- Ressalva Legal Obrigatória do Diagnóstico -->
                        <div class="pt-3 border-t border-white/10 space-y-1.5 text-[11px] sm:text-xs text-slate-300 leading-relaxed">
                            <p>
                                <strong class="text-amber-300 font-brand uppercase tracking-wider">Aviso Importante:</strong>
                                {{ extra.disclaimer_text || 'Os resultados apresentados são projeções ilustrativas e não representam garantia de economia. A economia efetiva dependerá da estrutura atual, dos custos identificados, das soluções implantadas e dos resultados comprovados durante a operação.' }}
                            </p>
                            <p class="text-slate-400">
                                {{ extra.contract_note || 'As condições de remuneração por desempenho serão definidas em proposta comercial e instrumento contratual específico.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
