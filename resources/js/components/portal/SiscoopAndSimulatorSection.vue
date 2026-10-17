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

const regularPrice = computed(() => Number(props.settings.sim_user_regular_price || 20));
const partnerPrice = computed(() => Number(props.settings.sim_user_partner_price || 10));
const savingsSharePercent = computed(() => Number(props.settings.sim_savings_share_percent || 30));

const netCooperativeMonthlyGain = computed(() => {
    return monthlyWasteSavings.value * ((100 - savingsSharePercent.value) / 100);
});

const userDiscountTotalMonthly = computed(() => {
    return usersCount.value * Math.max(0, regularPrice.value - partnerPrice.value);
});

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
        v-if="siscoop"
        id="siscoop3f"
        class="py-16 sm:py-24 section-dark-siscoop text-white relative overflow-hidden border-b border-cyan-500/20"
    >
        <div id="investimento" class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">
            <!-- Cabeçalho Editorial do Modelo de Investimento -->
            <div class="max-w-3xl mb-10 sm:mb-12" data-reveal>
                <div class="inline-flex items-center gap-2.5 pl-3 pr-4 py-1 bg-white/[0.06] border-l-2 border-[#80FFDB] rounded-r mb-3">
                    <span class="font-brand text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.14em] text-[#80FFDB]">
                        {{ siscoop.badge_text }}
                    </span>
                </div>
                <h2 class="font-brand text-2xl sm:text-4xl font-extrabold leading-tight tracking-[-0.02em]">
                    {{ siscoop.title }}
                    <span class="text-[#80FFDB]">{{ siscoop.highlighted_word }}</span>
                </h2>
                <p class="text-slate-300 text-sm sm:text-base mt-2.5 sm:mt-3 leading-relaxed">
                    {{ siscoop.subtitle }}
                </p>
            </div>

            <!-- Os 3 Pilares Econômicos com Layout Vertical Estruturado -->
            <div v-if="investment?.items?.length" class="grid md:grid-cols-3 gap-4 sm:gap-6 mb-10 sm:mb-14">
                <div
                    v-for="(rule, idx) in investment.items.slice(0, 3)"
                    :key="rule.id"
                    :class="['exec-card rounded-md bg-[#01162E]/90 border border-white/12 border-t-2 border-t-[#80FFDB] p-5 sm:p-7 flex flex-col justify-between shadow-lg', `reveal-delay-${idx + 1}`]"
                    data-reveal
                >
                    <div>
                        <!-- Topo: Número da Regra + Métrica em Destaque -->
                        <div class="flex flex-wrap items-baseline justify-between gap-2 pb-3.5 sm:pb-4 mb-3.5 sm:mb-4 border-b border-white/10">
                            <span class="font-brand text-2xl sm:text-3xl font-black text-[#80FFDB] tracking-tight">
                                {{ rule.highlight_metric }}
                            </span>
                            <span class="font-mono text-[10px] sm:text-[11px] font-bold uppercase tracking-widest text-cyan-300 bg-white/[0.06] px-2.5 py-1 rounded-xs">
                                {{ rule.badge || `REGRA 0${idx + 1}` }}
                            </span>
                        </div>

                        <!-- Corpo: Título e Descrição com 100% da Largura do Card -->
                        <h3 class="font-brand text-base sm:text-lg font-extrabold text-white leading-snug">
                            {{ rule.title }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-300 mt-2 leading-relaxed">
                            {{ rule.description }}
                        </p>
                    </div>

                    <div class="mt-4 sm:mt-5 pt-3 border-t border-white/[0.06] flex items-center justify-between text-[10px] sm:text-[11px] text-slate-400 font-mono">
                        <span>MODELO DE PARCERIA</span>
                        <span class="text-[#80FFDB]">RISCO ZERO</span>
                    </div>
                </div>
            </div>

            <!-- Painel Simulador Financeiro Executivo (Otimizado para Toque no Celular) -->
            <div
                class="rounded-lg bg-[#010E1F] border border-cyan-400/25 shadow-[0_24px_60px_rgba(0,0,0,0.45)] overflow-hidden"
                data-reveal="scale"
            >
                <!-- Barra Superior de Status do Simulador -->
                <div class="px-5 sm:px-9 py-3.5 sm:py-4 bg-white/[0.03] border-b border-white/10 flex flex-wrap items-center justify-between gap-2 sm:gap-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-xs bg-[#00E5FF] shrink-0"></span>
                        <span class="font-brand text-[11px] sm:text-xs font-bold uppercase tracking-[0.12em] sm:tracking-[0.14em] text-[#00E5FF]">
                            Simulador Financeiro de Parceria (Modelo CBSAÚDE)
                        </span>
                    </div>
                    <span class="text-[10px] sm:text-xs text-slate-400 font-mono">
                        30 DIAS GRÁTIS • SEM DESEMBOLSO INICIAL
                    </span>
                </div>

                <div class="p-5 sm:p-9">
                    <div class="grid lg:grid-cols-12 gap-7 lg:gap-10 items-start">
                        <!-- Coluna Esquerda: Controles Deslizantes Touch-Friendly (6 Colunas) -->
                        <div class="lg:col-span-6 space-y-5 sm:space-y-6">
                            <div>
                                <h3 class="font-brand text-xl sm:text-2xl font-extrabold text-white tracking-tight">
                                    Calcule o Retorno para sua Cooperativa
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-300 mt-1">
                                    Deslize os controles abaixo para projetar a retenção mensal e o benefício aos cooperados:
                                </p>
                            </div>

                            <!-- Slider 1 -->
                            <div class="p-4 sm:p-5 rounded-md bg-white/[0.04] border border-white/10 space-y-3">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="text-xs sm:text-sm font-brand font-semibold text-slate-200">
                                        Usuários Vinculados
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

                            <!-- Slider 2 -->
                            <div class="p-4 sm:p-5 rounded-md bg-white/[0.04] border border-white/10 space-y-3">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="text-xs sm:text-sm font-brand font-semibold text-slate-200">
                                        Economia Mensal Estimada
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

                        <!-- Coluna Direita: Painel de Resultados Estruturado (6 Colunas) -->
                        <div class="lg:col-span-6 space-y-3.5 sm:space-y-4">
                            <!-- Card Principal: Retenção Líquida na Cooperativa -->
                            <div class="p-4 sm:p-6 rounded-md bg-emerald-500/[0.08] border border-emerald-400/30 border-l-4 border-l-[#80FFDB] flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
                                <div>
                                    <span class="text-[10px] sm:text-[11px] font-brand font-bold uppercase tracking-wider text-emerald-300 block">
                                        Economia Líquida Retida na Cooperativa (70%)
                                    </span>
                                    <div class="font-brand text-2xl sm:text-3xl font-black text-[#80FFDB] mt-1 tracking-tight">
                                        {{ formatBRL(netCooperativeMonthlyGain) }}<span class="text-sm sm:text-base font-bold text-emerald-200">/mês</span>
                                    </div>
                                </div>
                                <div class="sm:text-right pt-2.5 sm:pt-0 border-t sm:border-t-0 border-white/10 flex sm:block items-center justify-between">
                                    <span class="text-[11px] text-slate-300 block">Impacto Anualizado</span>
                                    <strong class="font-brand text-sm sm:text-base font-extrabold text-white">
                                        {{ formatBRL(netCooperativeMonthlyGain * 12) }}/ano
                                    </strong>
                                </div>
                            </div>

                            <!-- 2 Cards Secundários -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                                <div class="p-4 sm:p-5 rounded-md bg-white/[0.04] border border-white/10">
                                    <span class="text-[10px] sm:text-[11px] font-brand font-bold uppercase tracking-wider text-slate-300 block">
                                        Investimento de Implantação
                                    </span>
                                    <strong class="font-brand text-xl sm:text-2xl font-black text-white mt-1 block tracking-tight">
                                        R$ 0,00
                                    </strong>
                                    <span class="text-xs text-emerald-300 mt-1 block font-medium">
                                        ✓ {{ settings.sim_trial_days }} dias de avaliação gratuita
                                    </span>
                                </div>

                                <div class="p-4 sm:p-5 rounded-md bg-[#00509D]/25 border border-cyan-400/30">
                                    <span class="text-[10px] sm:text-[11px] font-brand font-bold uppercase tracking-wider text-cyan-200 block">
                                        Benefício Direto aos Usuários
                                    </span>
                                    <strong class="font-brand text-xl sm:text-2xl font-black text-[#00E5FF] mt-1 block tracking-tight">
                                        {{ formatBRL(userDiscountTotalMonthly) }}<span class="text-xs sm:text-sm font-bold">/mês</span>
                                    </strong>
                                    <span class="text-xs text-slate-300 mt-1 block">
                                        R$ {{ partnerPrice.toFixed(2).replace('.', ',') }}/usuário (50% OFF)
                                    </span>
                                </div>
                            </div>

                            <!-- Botões de Ação do Simulador -->
                            <div class="pt-1 sm:pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3">
                                <button
                                    type="button"
                                    @click="emit('select-vertical', 'SISCOOP3F - Gestão Cooperativista', usersCount)"
                                    class="flex-1 py-4 px-4 sm:px-5 rounded font-brand font-bold text-xs uppercase tracking-wider text-[#01162E] bg-[#00E5FF] hover:bg-[#80FFDB] transition text-center cursor-pointer shadow-md"
                                >
                                    Solicitar Carta de Intenção →
                                </button>
                                <a
                                    :href="settings.siscoop3f_url"
                                    target="_blank"
                                    rel="noopener"
                                    class="py-3.5 sm:py-4 px-5 rounded font-brand font-bold text-xs uppercase tracking-wider text-white bg-white/[0.08] hover:bg-white/[0.15] border border-white/20 transition text-center whitespace-nowrap"
                                >
                                    Abrir Sistema ↗
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
