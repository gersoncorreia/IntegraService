<script setup>
import { reactive, ref, watch, computed } from 'vue';
import BrandLogo from '../ui/BrandLogo.vue';
import AppIcon from '../ui/AppIcon.vue';

const props = defineProps({
    contact: { type: Object, default: null },
    settings: { type: Object, required: true },
    urls: { type: Object, required: true },
    selectedVertical: { type: String, default: 'SISCOOP3F - Gestão Cooperativista' },
    preselectedUsers: { type: Number, default: null },
});

const form = reactive({
    name: '',
    organization: '',
    role: '',
    phone: '',
    email: '',
    vertical_interest: props.selectedVertical,
    estimated_users: props.preselectedUsers || '',
    message: '',
});

watch(() => props.selectedVertical, (val) => {
    if (val) form.vertical_interest = val;
});

watch(() => props.preselectedUsers, (val) => {
    if (val) form.estimated_users = val;
});

const submitting = ref(false);
const submittedSuccess = ref('');
const errorMessage = ref('');

const whatsappUrl = computed(() => {
    const cleanPhone = String(props.settings.whatsapp_number || '').replace(/\D/g, '');
    const text = encodeURIComponent('Olá! Vim pelo Portal IntegreService e gostaria de conversar sobre uma proposta comercial.');
    return `https://wa.me/${cleanPhone}?text=${text}`;
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
                estimated_users: form.estimated_users ? Number(form.estimated_users) : null,
            }),
        });

        const data = await response.json();

        if (!response.ok) {
            errorMessage.value = data.message || 'Verifique os campos preenchidos e tente novamente.';
        } else {
            submittedSuccess.value = data.message || 'Sua solicitação foi registrada com sucesso no CRM MySQL!';
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
        <!-- SEÇÃO DE CONTATO & SOLICITAÇÃO DE PROPOSTA EXECUTIVA -->
        <section v-if="contact" id="contato" class="py-16 sm:py-24 section-light-grid relative">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="grid lg:grid-cols-12 gap-10 lg:gap-12 items-start">
                    <!-- Coluna Esquerda: Informações Diretas da Diretoria (5 Colunas) -->
                    <div class="lg:col-span-5 space-y-5 sm:space-y-6" data-reveal="left">
                        <div class="inline-flex items-center gap-2.5 pl-3 pr-4 py-1 bg-[#022B5B]/[0.06] border-l-2 border-[#022B5B] rounded-r">
                            <span class="font-brand text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.14em] text-[#022B5B]">
                                {{ contact.badge_text }}
                            </span>
                        </div>

                        <h2 class="font-brand text-2xl sm:text-4xl font-extrabold text-[#022B5B] leading-tight tracking-[-0.02em]">
                            {{ contact.title }}
                            <span class="text-[#0077B6]">{{ contact.highlighted_word }}</span>
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
                                        Consultor e Representante Oficial
                                    </span>
                                    <h4 class="font-brand font-bold text-base sm:text-lg text-[#022B5B] mt-0.5">
                                        Senhor {{ settings.consultant_name }}
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
                                        Canais Diretos de Atendimento
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

                        <a
                            :href="whatsappUrl"
                            target="_blank"
                            rel="noopener"
                            class="w-full inline-flex items-center justify-center gap-3 py-4 px-6 rounded font-brand font-bold text-xs uppercase tracking-[0.1em] text-white bg-emerald-700 hover:bg-emerald-600 border-b-2 border-emerald-400 shadow-sm transition"
                        >
                            <span>Falar Agora pelo WhatsApp Executivo</span>
                            <span>↗</span>
                        </a>
                    </div>

                    <!-- Coluna Direita: Formulário perfeitamente alinhado e 16px no mobile (zero iOS auto-zoom) -->
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
                                            Canal Direto de Propostas
                                        </span>
                                        <h3 class="font-brand text-xl sm:text-2xl font-extrabold text-[#022B5B] mt-0.5">
                                            Solicitar Proposta ou Diagnóstico
                                        </h3>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-xs bg-slate-100 text-slate-600 font-mono text-[10px] sm:text-[11px]">
                                        CRM Integrado
                                    </span>
                                </div>

                                <Transition name="fade-slide">
                                    <div v-if="submittedSuccess" class="mt-5 sm:mt-6 p-4 rounded bg-emerald-50 border border-emerald-200 border-l-4 border-l-emerald-600 text-emerald-900 flex items-start gap-3">
                                        <span class="w-5 h-5 rounded-xs bg-emerald-600 text-white flex items-center justify-center shrink-0 mt-0.5 text-xs font-bold">✓</span>
                                        <div>
                                            <strong class="font-brand font-bold text-sm block">Solicitação Registrada com Sucesso!</strong>
                                            <span class="text-xs">{{ submittedSuccess }}</span>
                                        </div>
                                    </div>
                                </Transition>

                                <Transition name="fade-slide">
                                    <div v-if="errorMessage" class="mt-5 sm:mt-6 p-4 rounded bg-rose-50 border border-rose-200 border-l-4 border-l-rose-600 text-rose-800 text-xs font-medium">
                                        {{ errorMessage }}
                                    </div>
                                </Transition>

                                <!-- Formulário Organizado em Grade Simétrica 2x2 + Teclados Nativos Mobile -->
                                <form @submit.prevent="submitLead" class="mt-5 sm:mt-6 space-y-4 sm:space-y-5">
                                    <!-- Linha 1: Nome Completo + Instituição -->
                                    <div class="grid sm:grid-cols-2 gap-4 sm:gap-5">
                                        <div>
                                            <label class="block text-xs font-brand font-bold uppercase tracking-wider text-[#022B5B] mb-1.5 sm:mb-2">
                                                Seu Nome Completo <span class="text-[#00B4D8]">*</span>
                                            </label>
                                            <input
                                                type="text"
                                                v-model="form.name"
                                                required
                                                autocomplete="name"
                                                placeholder="Ex: Alan Nogueira"
                                                class="w-full h-11 px-4 rounded bg-[#F8FAFC] border border-slate-300 focus:border-[#00509D] focus:bg-white focus:ring-2 focus:ring-[#00509D]/15 focus:outline-none text-base sm:text-sm text-slate-800 transition"
                                            >
                                        </div>
                                        <div>
                                            <label class="block text-xs font-brand font-bold uppercase tracking-wider text-[#022B5B] mb-1.5 sm:mb-2">
                                                Cooperativa / Empresa / Órgão
                                            </label>
                                            <input
                                                type="text"
                                                v-model="form.organization"
                                                autocomplete="organization"
                                                placeholder="Ex: CBSAÚDE"
                                                class="w-full h-11 px-4 rounded bg-[#F8FAFC] border border-slate-300 focus:border-[#00509D] focus:bg-white focus:ring-2 focus:ring-[#00509D]/15 focus:outline-none text-base sm:text-sm text-slate-800 transition"
                                            >
                                        </div>
                                    </div>

                                    <!-- Linha 2: E-mail Corporativo + Telefone/WhatsApp -->
                                    <div class="grid sm:grid-cols-2 gap-4 sm:gap-5">
                                        <div>
                                            <label class="block text-xs font-brand font-bold uppercase tracking-wider text-[#022B5B] mb-1.5 sm:mb-2">
                                                E-mail Corporativo <span class="text-[#00B4D8]">*</span>
                                            </label>
                                            <input
                                                type="email"
                                                inputmode="email"
                                                autocomplete="email"
                                                v-model="form.email"
                                                required
                                                placeholder="contato@instituicao.com.br"
                                                class="w-full h-11 px-4 rounded bg-[#F8FAFC] border border-slate-300 focus:border-[#00509D] focus:bg-white focus:ring-2 focus:ring-[#00509D]/15 focus:outline-none text-base sm:text-sm text-slate-800 transition"
                                            >
                                        </div>
                                        <div>
                                            <label class="block text-xs font-brand font-bold uppercase tracking-wider text-[#022B5B] mb-1.5 sm:mb-2">
                                                Telefone / WhatsApp <span class="text-[#00B4D8]">*</span>
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
                                    </div>

                                    <!-- Linha 3: Seu Cargo / Função + Nº Estimado de Usuários -->
                                    <div class="grid sm:grid-cols-2 gap-4 sm:gap-5">
                                        <div>
                                            <label class="block text-xs font-brand font-bold uppercase tracking-wider text-[#022B5B] mb-1.5 sm:mb-2">
                                                Seu Cargo / Função
                                            </label>
                                            <input
                                                type="text"
                                                autocomplete="organization-title"
                                                v-model="form.role"
                                                placeholder="Ex: Diretor Presidente"
                                                class="w-full h-11 px-4 rounded bg-[#F8FAFC] border border-slate-300 focus:border-[#00509D] focus:bg-white focus:ring-2 focus:ring-[#00509D]/15 focus:outline-none text-base sm:text-sm text-slate-800 transition"
                                            >
                                        </div>
                                        <div>
                                            <label class="block text-xs font-brand font-bold uppercase tracking-wider text-[#022B5B] mb-1.5 sm:mb-2">
                                                Nº Estimado de Usuários
                                            </label>
                                            <input
                                                type="number"
                                                inputmode="numeric"
                                                v-model="form.estimated_users"
                                                placeholder="Ex: 1500"
                                                class="w-full h-11 px-4 rounded bg-[#F8FAFC] border border-slate-300 focus:border-[#00509D] focus:bg-white focus:ring-2 focus:ring-[#00509D]/15 focus:outline-none text-base sm:text-sm text-slate-800 transition"
                                            >
                                        </div>
                                    </div>

                                    <!-- Linha 4: Solução / Vertical de Interesse -->
                                    <div>
                                        <label class="block text-xs font-brand font-bold uppercase tracking-wider text-[#022B5B] mb-1.5 sm:mb-2">
                                            Solução / Vertical de Interesse <span class="text-[#00B4D8]">*</span>
                                        </label>
                                        <select
                                            v-model="form.vertical_interest"
                                            class="w-full h-11 px-3.5 sm:px-4 rounded bg-[#F8FAFC] border border-slate-300 focus:border-[#00509D] focus:bg-white focus:ring-2 focus:ring-[#00509D]/15 focus:outline-none text-base sm:text-sm font-medium text-[#022B5B] transition"
                                        >
                                            <option value="SISCOOP3F - Gestão Cooperativista">SISCOOP3F — Gestão Cooperativista (30d sem custo)</option>
                                            <option value="Plataforma de Telemedicina">Saúde Digital — Plataforma de Telemedicina 24/7</option>
                                            <option value="A Clínica & Departamentos">Saúde Presencial — A Clínica & Especialidades</option>
                                            <option value="Consultoria, Auditoria & Mentoria">Inteligência Corporativa — Consultoria & Auditoria</option>
                                            <option value="Livro & Publicações">Autoridade Geral — Livro, Palestras & Publicações</option>
                                            <option value="Ecossistema Completo IntegreService">Parceria Completa — Todo o Ecossistema IntegreService</option>
                                        </select>
                                    </div>

                                    <!-- Linha 5: Mensagem -->
                                    <div>
                                        <label class="block text-xs font-brand font-bold uppercase tracking-wider text-[#022B5B] mb-1.5 sm:mb-2">
                                            Mensagem ou Necessidade Específica
                                        </label>
                                        <textarea
                                            v-model="form.message"
                                            rows="3"
                                            placeholder="Conte-nos brevemente sobre o cenário atual da sua Cooperativa, Clínica ou Empresa..."
                                            class="w-full p-4 rounded bg-[#F8FAFC] border border-slate-300 focus:border-[#00509D] focus:bg-white focus:ring-2 focus:ring-[#00509D]/15 focus:outline-none text-base sm:text-sm text-slate-800 transition"
                                        ></textarea>
                                    </div>

                                    <button
                                        type="submit"
                                        :disabled="submitting"
                                        class="w-full py-4 px-5 sm:px-8 rounded font-brand font-bold text-xs uppercase tracking-[0.1em] sm:tracking-[0.12em] text-white bg-[#022B5B] hover:bg-[#00509D] border-b-2 border-[#00E5FF] disabled:opacity-60 transition-all cursor-pointer shadow-sm"
                                    >
                                        <span v-if="submitting">Enviando Solicitação...</span>
                                        <span v-else>Enviar Solicitação para a Diretoria →</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- RODAPÉ INSTITUCIONAL ESCURO (Com espaço inferior extra no mobile para o Bottom Action Dock) -->
        <footer class="bg-[#011124] text-slate-300 pt-14 sm:pt-16 pb-24 lg:pb-12 border-t border-cyan-500/20">
            <div class="max-w-6xl mx-auto px-4 sm:px-6">
                <div class="grid md:grid-cols-2 lg:grid-cols-12 gap-8 sm:gap-10 pb-10 sm:pb-12 border-b border-white/10">
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
                        <p class="text-sm text-slate-400 max-w-md leading-relaxed">
                            {{ settings.footer_description }}
                        </p>
                        <div class="pt-1 text-xs text-cyan-300 font-brand font-semibold">
                            {{ settings.company_city }} • Representante: {{ settings.consultant_name }}
                        </div>
                    </div>

                    <div class="lg:col-span-4 space-y-2.5">
                        <h4 class="font-brand font-bold text-xs uppercase tracking-widest text-white mb-3">
                            Ecossistema da Marca
                        </h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#siscoop3f" class="hover:text-[#00E5FF] transition">SISCOOP3F — Gestão Cooperativista</a></li>
                            <li><a href="#investimento" class="hover:text-[#00E5FF] transition">Modelo de Investimento Sem Desembolso Inicial</a></li>
                            <li><a href="#ecossistema" class="hover:text-[#00E5FF] transition">Saúde Digital — Plataforma de Telemedicina</a></li>
                            <li><a href="#ecossistema" class="hover:text-[#00E5FF] transition">A Clínica & Departamentos Especializados</a></li>
                            <li><a href="#ecossistema" class="hover:text-[#00E5FF] transition">Consultoria, Auditoria & Mentoria Executiva</a></li>
                            <li><a href="#ecossistema" class="hover:text-[#00E5FF] transition">Autoridade Geral — Livro & Publicações</a></li>
                        </ul>
                    </div>

                    <div class="lg:col-span-3 space-y-3">
                        <h4 class="font-brand font-bold text-xs uppercase tracking-widest text-white mb-3">
                            Acesso às Plataformas
                        </h4>
                        <a :href="settings.siscoop3f_url" target="_blank" rel="noopener" class="flex items-center justify-between p-3.5 rounded bg-white/5 hover:bg-white/10 border border-white/10 border-l-2 border-l-[#80FFDB] text-xs font-brand font-bold text-[#80FFDB] transition">
                            <span>Acessar SISCOOP3F</span>
                            <span>↗</span>
                        </a>
                        <a :href="settings.telemedicine_url" target="_blank" rel="noopener" class="flex items-center justify-between p-3.5 rounded bg-white/5 hover:bg-white/10 border border-white/10 border-l-2 border-l-[#00F5D4] text-xs font-brand font-bold text-[#00F5D4] transition">
                            <span>Login Telemedicina</span>
                            <span>↗</span>
                        </a>
                        <a :href="urls.adminLogin" class="inline-block text-xs text-slate-400 hover:text-cyan-300 pt-2 transition">
                            Área Administrativa (CMS) →
                        </a>
                    </div>
                </div>

                <div class="pt-6 sm:pt-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left text-xs text-slate-400">
                    <p>© {{ new Date().getFullYear() }} {{ settings.footer_copyright }}</p>
                    <p class="font-mono text-[11px] text-slate-500">IntegreService • Rede de Serviços & Tecnologia</p>
                </div>
            </div>
        </footer>
    </div>
</template>
