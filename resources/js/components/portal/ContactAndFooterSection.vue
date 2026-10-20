<script setup>
import { reactive, ref, watch, computed } from 'vue';
import BrandLogo from '../ui/BrandLogo.vue';
import AppIcon from '../ui/AppIcon.vue';

const props = defineProps({
    contact: { type: Object, default: null },
    settings: { type: Object, required: true },
    urls: { type: Object, required: true },
    ecosystemTabs: { type: Array, default: () => [] },
    selectedVertical: { type: String, default: 'Gestão Cooperativista - SISCOOP3F' },
    preselectedUsers: { type: Number, default: null },
});

const showOptionalDetails = ref(false);
const privacyModalOpen = ref(false);

const form = reactive({
    name: '',
    organization: '',
    role: '',
    phone: '',
    email: '',
    vertical_interest: props.selectedVertical || 'Gestão Cooperativista - SISCOOP3F',
    estimated_users: props.preselectedUsers || '',
    message: '',
});

watch(() => props.selectedVertical, (val) => {
    if (val) form.vertical_interest = val;
});

watch(() => props.preselectedUsers, (val) => {
    if (val) {
        form.estimated_users = val;
        showOptionalDetails.value = true;
    }
});

const solutionOptions = computed(() => {
    const baseOptions = [
        'Gestão Cooperativista - SISCOOP3F',
        'Telemedicina',
        'Consultoria Executiva',
        'Base Científica',
        'Soluções para Gestão Pública',
    ];

    const dynamicTitles = (props.ecosystemTabs || [])
        .map((t) => t.tab_title)
        .filter((title) => title && !baseOptions.some((b) => b.toLowerCase().includes(title.toLowerCase())));

    return [...baseOptions, ...dynamicTitles];
});

const submitting = ref(false);
const submittedSuccess = ref('');
const errorMessage = ref('');

const whatsappUrl = computed(() => {
    const cleanPhone = String(props.settings.whatsapp_number || '').replace(/\D/g, '');
    const text = encodeURIComponent('Olá! Vim pelo Portal IntegreService e gostaria de agendar uma apresentação.');
    return `https://wa.me/${cleanPhone}?text=${text}`;
});

const privacyParagraphs = computed(() => {
    const raw =
        props.settings.privacy_policy_text ||
        'A IntegreService respeita a sua privacidade e utiliza os dados informados exclusivamente para responder à sua solicitação de apresentação ou diagnóstico institucional, em conformidade com a LGPD (Lei nº 13.709/2018).';
    return String(raw)
        .split('\n')
        .map((p) => p.trim())
        .filter(Boolean);
});

const submitLead = async () => {
    submitting.value = true;
    errorMessage.value = '';
    submittedSuccess.value = '';

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const response = await fetch(props.urls.storeLead, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({
                ...form,
                email: form.email ? form.email : null,
                estimated_users: form.estimated_users ? Number(form.estimated_users) : null,
            }),
        });

        const data = await response.json();

        if (!response.ok) {
            errorMessage.value = data.message || 'Verifique os campos preenchidos e tente novamente.';
        } else {
            submittedSuccess.value = data.message || 'Sua solicitação foi registrada com sucesso! Nossa equipe entrará em contato.';
            form.name = '';
            form.organization = '';
            form.role = '';
            form.phone = '';
            form.email = '';
            form.message = '';
        }
    } catch (e) {
        errorMessage.value = 'Ocorreu um erro de conexão ao enviar sua solicitação.';
    } finally {
        submitting.value = false;
    }
};
</script>

<template>
    <div>
        <!-- SEÇÃO DE AGENDAMENTO DE APRESENTAÇÃO & FORMULÁRIO SIMPLIFICADO (Seções 6.7 e 6.8 do PDF) -->
        <section v-if="contact" id="contato" class="py-16 sm:py-24 section-light-grid relative">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="grid lg:grid-cols-12 gap-10 lg:gap-12 items-start">
                    <!-- Coluna Esquerda: Jornada Comercial e Canais Diretos (5 Colunas) -->
                    <div class="lg:col-span-5 space-y-5 sm:space-y-6" data-reveal="left">
                        <div class="inline-flex items-center gap-2.5 pl-3 pr-4 py-1 bg-[#022B5B]/[0.06] border-l-2 border-[#022B5B] rounded-r">
                            <span class="font-brand text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.14em] text-[#022B5B]">
                                {{ contact.badge_text || 'ATENDIMENTO COMERCIAL & AGENDAMENTO' }}
                            </span>
                        </div>

                        <h2 class="font-brand text-2xl sm:text-4xl font-extrabold text-[#022B5B] leading-tight tracking-[-0.02em]">
                            {{ contact.title || 'Vamos conhecer as necessidades da' }}
                            <span class="text-[#0077B6]">{{ contact.highlighted_word || 'sua instituição?' }}</span>
                        </h2>

                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                            {{ contact.subtitle }}
                        </p>

                        <!-- Cards de Contato Estruturados com Borda Lateral -->
                        <div class="space-y-3 pt-1">
                            <div class="p-4 sm:p-5 rounded-md bg-white border border-slate-200 border-l-4 border-l-[#022B5B] shadow-2xs flex items-start gap-3.5 sm:gap-4">
                                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded bg-[#022B5B] text-[#00E5FF] flex items-center justify-center shrink-0">
                                    <AppIcon name="users" class="w-5 h-5" />
                                </div>
                                <div class="min-w-0">
                                    <span class="text-[10px] sm:text-[11px] font-brand font-bold uppercase tracking-wider text-[#0077B6] block">
                                        Liderança e Relacionamento Institucional
                                    </span>
                                    <h4 class="font-brand font-bold text-base sm:text-lg text-[#022B5B] mt-0.5">
                                        {{ settings.consultant_name }}
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        {{ settings.consultant_role }} • {{ settings.company_city }}
                                    </p>
                                </div>
                            </div>

                            <div class="p-4 sm:p-5 rounded-md bg-white border border-slate-200 border-l-4 border-l-[#0077B6] shadow-2xs flex items-start gap-3.5 sm:gap-4">
                                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded bg-[#0077B6] text-white flex items-center justify-center shrink-0">
                                    <AppIcon name="device-mobile" class="w-5 h-5" />
                                </div>
                                <div class="min-w-0">
                                    <span class="text-[10px] sm:text-[11px] font-brand font-bold uppercase tracking-wider text-[#0077B6] block">
                                        Atendimento Comercial
                                    </span>
                                    <p class="text-sm font-brand font-bold text-[#022B5B] mt-0.5">
                                        {{ settings.contact_phone }}
                                    </p>
                                    <p class="text-xs text-slate-500 mt-0.5 break-all">
                                        {{ settings.contact_email }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-2.5">
                            <a
                                href="#form-proposta"
                                class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 rounded font-brand font-bold text-xs uppercase tracking-[0.08em] text-white bg-[#022B5B] hover:bg-[#00509D] border-b-2 border-[#00E5FF] transition text-center"
                            >
                                <span>{{ contact.primary_cta_text || 'Agendar apresentação' }}</span>
                                <span>→</span>
                            </a>
                            <a
                                :href="whatsappUrl"
                                target="_blank"
                                rel="noopener"
                                class="w-full inline-flex items-center justify-center gap-2 py-3.5 px-4 rounded font-brand font-bold text-xs uppercase tracking-[0.08em] text-white bg-emerald-700 hover:bg-emerald-600 border-b-2 border-emerald-400 transition text-center"
                            >
                                <span>{{ contact.secondary_cta_text || 'Solicitar diagnóstico' }}</span>
                                <span>↗</span>
                            </a>
                        </div>
                    </div>

                    <!-- Coluna Direita: Formulário Simplificado de 4 Campos Essenciais (Seção 6.8 do PDF) -->
                    <div class="lg:col-span-7" data-reveal="right">
                        <div
                            id="form-proposta"
                            class="rounded-lg bg-white border border-slate-200/95 shadow-[0_18px_50px_rgba(2,43,91,0.07)] overflow-hidden"
                        >
                            <!-- Barra Superior Institucional do Formulário -->
                            <div class="h-1.5 w-full bg-gradient-to-r from-[#022B5B] via-[#00509D] to-[#00B4D8]"></div>

                            <div class="p-5 sm:p-10">
                                <div class="pb-5 sm:pb-6 border-b border-slate-200 flex flex-wrap items-center justify-between gap-2 sm:gap-3">
                                    <div>
                                        <span class="text-[10px] sm:text-[11px] font-brand font-bold uppercase tracking-[0.14em] text-[#0077B6] block">
                                            Atendimento Especializado
                                        </span>
                                        <h3 class="font-brand text-xl sm:text-2xl font-extrabold text-[#022B5B] mt-0.5">
                                            Solicite uma apresentação personalizada
                                        </h3>
                                        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                                            Conte-nos como podemos ajudar sua instituição.
                                        </p>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-xs bg-slate-100 text-slate-600 font-mono text-[10px] sm:text-[11px]">
                                        Rápido • 4 Campos
                                    </span>
                                </div>

                                <Transition name="fade-slide">
                                    <div v-if="submittedSuccess" class="mt-5 sm:mt-6 p-4 rounded bg-emerald-50 border border-emerald-200 border-l-4 border-l-emerald-600 text-emerald-900 flex items-start gap-3">
                                        <span class="w-5 h-5 rounded-xs bg-emerald-600 text-white flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">✓</span>
                                        <div>
                                            <strong class="font-brand font-bold text-sm block">Solicitação Recebida com Sucesso!</strong>
                                            <span class="text-xs">{{ submittedSuccess }}</span>
                                        </div>
                                    </div>
                                </Transition>

                                <Transition name="fade-slide">
                                    <div v-if="errorMessage" class="mt-5 sm:mt-6 p-4 rounded bg-rose-50 border border-rose-200 border-l-4 border-l-rose-600 text-rose-800 text-xs font-medium">
                                        {{ errorMessage }}
                                    </div>
                                </Transition>

                                <!-- Formulário Simplificado (Seção 6.8: Nome completo; Nome da instituição; WhatsApp; Qual solução deseja conhecer?) -->
                                <form @submit.prevent="submitLead" class="mt-5 sm:mt-6 space-y-4 sm:space-y-5">
                                    <div class="grid sm:grid-cols-2 gap-4 sm:gap-5">
                                        <!-- Campo 1: Nome completo -->
                                        <div>
                                            <label class="block text-xs font-brand font-bold uppercase tracking-wider text-[#022B5B] mb-1.5 sm:mb-2">
                                                Nome completo <span class="text-[#00B4D8]">*</span>
                                            </label>
                                            <input
                                                type="text"
                                                v-model="form.name"
                                                required
                                                autocomplete="name"
                                                placeholder="Informe seu nome completo"
                                                class="w-full h-11 px-4 rounded bg-[#F8FAFC] border border-slate-300 focus:border-[#00509D] focus:bg-white focus:ring-2 focus:ring-[#00509D]/15 focus:outline-none text-base sm:text-sm text-slate-800 transition"
                                            >
                                        </div>

                                        <!-- Campo 2: Nome da instituição -->
                                        <div>
                                            <label class="block text-xs font-brand font-bold uppercase tracking-wider text-[#022B5B] mb-1.5 sm:mb-2">
                                                Nome da instituição <span class="text-[#00B4D8]">*</span>
                                            </label>
                                            <input
                                                type="text"
                                                v-model="form.organization"
                                                required
                                                autocomplete="organization"
                                                placeholder="Cooperativa, empresa ou órgão público"
                                                class="w-full h-11 px-4 rounded bg-[#F8FAFC] border border-slate-300 focus:border-[#00509D] focus:bg-white focus:ring-2 focus:ring-[#00509D]/15 focus:outline-none text-base sm:text-sm text-slate-800 transition"
                                            >
                                        </div>
                                    </div>

                                    <div class="grid sm:grid-cols-2 gap-4 sm:gap-5">
                                        <!-- Campo 3: WhatsApp -->
                                        <div>
                                            <label class="block text-xs font-brand font-bold uppercase tracking-wider text-[#022B5B] mb-1.5 sm:mb-2">
                                                WhatsApp / Telefone <span class="text-[#00B4D8]">*</span>
                                            </label>
                                            <input
                                                type="tel"
                                                inputmode="tel"
                                                autocomplete="tel"
                                                v-model="form.phone"
                                                required
                                                placeholder="(68) 99999-0000"
                                                class="w-full h-11 px-4 rounded bg-[#F8FAFC] border border-slate-300 focus:border-[#00509D] focus:bg-white focus:ring-2 focus:ring-[#00509D]/15 focus:outline-none text-base sm:text-sm text-slate-800 transition"
                                            >
                                        </div>

                                        <!-- Campo 4: Qual solução deseja conhecer? -->
                                        <div>
                                            <label class="block text-xs font-brand font-bold uppercase tracking-wider text-[#022B5B] mb-1.5 sm:mb-2">
                                                Qual solução deseja conhecer? <span class="text-[#00B4D8]">*</span>
                                            </label>
                                            <select
                                                v-model="form.vertical_interest"
                                                class="w-full h-11 px-3.5 sm:px-4 rounded bg-[#F8FAFC] border border-slate-300 focus:border-[#00509D] focus:bg-white focus:ring-2 focus:ring-[#00509D]/15 focus:outline-none text-base sm:text-sm font-medium text-[#022B5B] transition"
                                            >
                                                <option
                                                    v-for="opt in solutionOptions"
                                                    :key="opt"
                                                    :value="opt"
                                                >
                                                    {{ opt }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Opção Expansível para Detalhes Adicionais (Sem sobrecarregar o celular!) -->
                                    <div>
                                        <button
                                            type="button"
                                            @click="showOptionalDetails = !showOptionalDetails"
                                            class="text-xs font-brand font-bold text-[#0077B6] hover:text-[#022B5B] inline-flex items-center gap-1.5 cursor-pointer transition"
                                        >
                                            <span>{{ showOptionalDetails ? '− Ocultar campos opcionais' : '+ Adicionar e-mail corporativo ou mensagem (opcional)' }}</span>
                                        </button>

                                        <div v-if="showOptionalDetails" class="mt-3 pt-3 border-t border-slate-100 space-y-4">
                                            <div class="grid sm:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-xs font-brand font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                                        E-mail Corporativo (Opcional)
                                                    </label>
                                                    <input
                                                        type="email"
                                                        inputmode="email"
                                                        autocomplete="email"
                                                        v-model="form.email"
                                                        placeholder="contato@instituicao.com.br"
                                                        class="w-full h-11 px-4 rounded bg-[#F8FAFC] border border-slate-300 focus:border-[#00509D] focus:bg-white focus:outline-none text-base sm:text-sm text-slate-800 transition"
                                                    >
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-brand font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                                        Cargo / Função (Opcional)
                                                    </label>
                                                    <input
                                                        type="text"
                                                        v-model="form.role"
                                                        placeholder="Ex: Diretor, Secretário, Gestor"
                                                        class="w-full h-11 px-4 rounded bg-[#F8FAFC] border border-slate-300 focus:border-[#00509D] focus:bg-white focus:outline-none text-base sm:text-sm text-slate-800 transition"
                                                    >
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-xs font-brand font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                                    Necessidade específica da instituição (Opcional)
                                                </label>
                                                <textarea
                                                    v-model="form.message"
                                                    rows="2"
                                                    placeholder="Descreva brevemente como podemos apoiar sua instituição..."
                                                    class="w-full p-3.5 rounded bg-[#F8FAFC] border border-slate-300 focus:border-[#00509D] focus:bg-white focus:outline-none text-base sm:text-sm text-slate-800 transition"
                                                ></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button
                                        type="submit"
                                        :disabled="submitting"
                                        class="w-full py-4 px-5 sm:px-8 rounded font-brand font-bold text-xs uppercase tracking-[0.1em] sm:tracking-[0.12em] text-white bg-[#022B5B] hover:bg-[#00509D] border-b-2 border-[#00E5FF] disabled:opacity-60 transition-all cursor-pointer shadow-sm"
                                    >
                                        <span v-if="submitting">Enviando Solicitação...</span>
                                        <span v-else>Quero falar com um especialista →</span>
                                    </button>

                                    <!-- Aviso de Privacidade e LGPD (Seção 6.8 do PDF) -->
                                    <p class="text-[11px] sm:text-xs text-slate-500 text-center leading-relaxed pt-1">
                                        Seus dados serão utilizados para responder à sua solicitação, conforme nossa
                                        <button
                                            type="button"
                                            @click="privacyModalOpen = true"
                                            class="font-semibold text-[#00509D] hover:underline cursor-pointer"
                                        >
                                            Política de Privacidade e Proteção de Dados (LGPD)
                                        </button>.
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- RODAPÉ INSTITUCIONAL REFORMULADO (Seção 6.9 do PDF) -->
        <footer class="bg-[#011124] text-slate-300 pt-14 sm:pt-16 pb-24 lg:pb-12 border-t border-cyan-500/20">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="grid md:grid-cols-2 lg:grid-cols-12 gap-8 sm:gap-10 pb-10 sm:pb-12 border-b border-white/10">
                    <!-- Coluna 1: Identidade e Propósito -->
                    <div class="lg:col-span-5 space-y-4">
                        <BrandLogo
                            :part1="settings.brand_part_1"
                            :part2="settings.brand_part_2"
                            :tagline="settings.brand_tagline"
                            :logoPath="settings.logo_path"
                            theme="dark"
                            size="md"
                            href="#inicio"
                        />
                        <p class="text-sm text-slate-300 max-w-md leading-relaxed">
                            {{ settings.footer_description || 'Conectamos tecnologia, gestão, saúde digital e conhecimento para apoiar o desenvolvimento de instituições e organizações.' }}
                        </p>
                        <div class="pt-1 space-y-1 text-xs text-slate-400">
                            <p class="text-cyan-300 font-brand font-semibold">
                                Relacionamento institucional: {{ settings.company_city }}
                            </p>
                            <p>E-mail: <a :href="`mailto:${settings.contact_email}`" class="text-white hover:text-[#00E5FF] transition">{{ settings.contact_email }}</a></p>
                            <p v-if="settings.legal_name || settings.cnpj" class="text-[11px] text-slate-400">
                                {{ settings.legal_name }} <span v-if="settings.cnpj">• CNPJ: {{ settings.cnpj }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Coluna 2: Nossas Soluções & Links Institucionais -->
                    <div class="lg:col-span-4 space-y-2.5">
                        <h4 class="font-brand font-bold text-xs uppercase tracking-widest text-white mb-3">
                            Nossas Soluções & Institucional
                        </h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#ecossistema" class="hover:text-[#00E5FF] transition">Gestão Cooperativista — SISCOOP3F</a></li>
                            <li><a href="#ecossistema" class="hover:text-[#00E5FF] transition">Telemedicina 24/7 — Saúde Digital</a></li>
                            <li><a href="#ecossistema" class="hover:text-[#00E5FF] transition">Consultoria Executiva — Gestão e Resultados</a></li>
                            <li><a href="#ecossistema" class="hover:text-[#00E5FF] transition">Base Científica — Conhecimento Aplicado</a></li>
                            <li><a href="#gestao-publica" class="hover:text-[#00E5FF] transition">Soluções para a Gestão Pública</a></li>
                            <li><a href="#identidade" class="hover:text-[#00E5FF] transition">Sobre nós & Liderança Institucional</a></li>
                        </ul>
                    </div>

                    <!-- Coluna 3: Atendimento Comercial e Sistemas -->
                    <div class="lg:col-span-3 space-y-3">
                        <h4 class="font-brand font-bold text-xs uppercase tracking-widest text-white mb-3">
                            Atendimento & Sistemas
                        </h4>
                        <a
                            href="#contato"
                            class="flex items-center justify-between p-3.5 rounded bg-[#00E5FF]/15 hover:bg-[#00E5FF]/25 border border-[#00E5FF]/40 text-xs font-brand font-bold text-[#00E5FF] transition"
                        >
                            <span>Fale com nossa equipe</span>
                            <span>→</span>
                        </a>
                        <a :href="settings.siscoop3f_url" target="_blank" rel="noopener" class="flex items-center justify-between p-3.5 rounded bg-white/5 hover:bg-white/10 border border-white/10 border-l-2 border-l-[#80FFDB] text-xs font-brand font-bold text-[#80FFDB] transition">
                            <span>Acessar SISCOOP3F</span>
                            <span>↗</span>
                        </a>
                        <a :href="settings.telemedicine_url" target="_blank" rel="noopener" class="flex items-center justify-between p-3.5 rounded bg-white/5 hover:bg-white/10 border border-white/10 border-l-2 border-l-[#00F5D4] text-xs font-brand font-bold text-[#00F5D4] transition">
                            <span>Login Telemedicina</span>
                            <span>↗</span>
                        </a>
                    </div>
                </div>

                <!-- Barra Inferior: Links e Copyright (Seção 6.9 do PDF) -->
                <div class="pt-6 sm:pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left text-xs text-slate-400">
                    <p>© {{ new Date().getFullYear() }} {{ settings.footer_copyright }}</p>
                    <div class="flex flex-wrap items-center justify-center gap-4 text-xs">
                        <a href="#identidade" class="hover:text-white transition">Sobre nós</a>
                        <span class="text-slate-600">|</span>
                        <a href="#ecossistema" class="hover:text-white transition">Nossas soluções</a>
                        <span class="text-slate-600">|</span>
                        <a href="#contato" class="hover:text-white transition">Contato</a>
                        <span class="text-slate-600">|</span>
                        <button
                            type="button"
                            @click="privacyModalOpen = true"
                            class="hover:text-[#00E5FF] transition cursor-pointer underline underline-offset-4"
                        >
                            Política de Privacidade
                        </button>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Modal Institucional de Política de Privacidade & LGPD -->
        <Transition name="modal-fade">
            <div
                v-if="privacyModalOpen"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
                @click.self="privacyModalOpen = false"
            >
                <div class="w-full max-w-2xl rounded-lg bg-white border border-slate-200 text-slate-800 shadow-2xl overflow-hidden max-h-[85vh] flex flex-col">
                    <div class="h-1.5 w-full bg-gradient-to-r from-[#022B5B] via-[#00509D] to-[#00E5FF]"></div>

                    <div class="p-5 sm:p-7 border-b border-slate-200 flex items-center justify-between gap-4">
                        <div>
                            <span class="text-[10px] font-brand font-bold uppercase tracking-widest text-[#0077B6] block">
                                Conformidade Legal • Lei nº 13.709/2018 (LGPD)
                            </span>
                            <h3 class="font-brand text-lg sm:text-xl font-extrabold text-[#022B5B] mt-0.5">
                                Política de Privacidade e Proteção de Dados
                            </h3>
                        </div>
                        <button
                            type="button"
                            @click="privacyModalOpen = false"
                            class="w-8 h-8 rounded bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center font-bold cursor-pointer"
                        >
                            ✕
                        </button>
                    </div>

                    <div class="p-5 sm:p-7 overflow-y-auto space-y-3.5 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        <p v-for="(paragraph, idx) in privacyParagraphs" :key="idx">
                            {{ paragraph }}
                        </p>
                    </div>

                    <div class="p-4 sm:p-5 bg-slate-50 border-t border-slate-200 flex items-center justify-between gap-3">
                        <span class="text-xs text-slate-500">
                            Canal oficial: <strong>{{ settings.contact_email }}</strong>
                        </span>
                        <button
                            type="button"
                            @click="privacyModalOpen = false"
                            class="px-5 py-2.5 rounded font-brand font-bold text-xs uppercase tracking-wider text-white bg-[#022B5B] hover:bg-[#00509D] transition cursor-pointer"
                        >
                            Entendi e Fechar
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>
