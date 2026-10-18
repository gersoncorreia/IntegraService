@extends('admin.layout')

@section('title', 'Configurações Globais & Simulador')
@section('header', 'Configurações Globais, Links & Simulador SISCOOP3F')
@section('subheader', 'Altere textos da marca, consultor responsável, WhatsApp, links das plataformas e parâmetros financeiros do simulador.')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Bloco 1: Identidade da Marca & Consultor -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-5">
            <h2 class="font-brand text-lg font-extrabold text-[#022B5B] border-b border-slate-100 pb-3">
                1. Identidade da Marca (Tipografia HTML/CSS) & Responsável
            </h2>

            <div class="grid sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Parte 1 da Marca (ExtraBold)</label>
                    <input type="text" name="brand_part_1" value="{{ old('brand_part_1', $settings->brand_part_1) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-bold text-[#022B5B]">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Parte 2 da Marca (Medium Cyan)</label>
                    <input type="text" name="brand_part_2" value="{{ old('brand_part_2', $settings->brand_part_2) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-medium text-[#00B4D8]">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Tagline Oficial</label>
                    <input type="text" name="brand_tagline" value="{{ old('brand_tagline', $settings->brand_tagline) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                </div>
            </div>

            <div class="grid sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Nome do Consultor / Representante</label>
                    <input type="text" name="consultant_name" value="{{ old('consultant_name', $settings->consultant_name) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Cargo / Título do Consultor</label>
                    <input type="text" name="consultant_role" value="{{ old('consultant_role', $settings->consultant_role) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Cidade / Sede</label>
                    <input type="text" name="company_city" value="{{ old('company_city', $settings->company_city) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                </div>
            </div>
        </div>

        <!-- Bloco 2: Links das Plataformas & Contatos -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-5">
            <h2 class="font-brand text-lg font-extrabold text-[#022B5B] border-b border-slate-100 pb-3">
                2. Links Oficiais dos Produtos e Canais de Contato
            </h2>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">URL Oficial do SISCOOP3F</label>
                    <input type="url" name="siscoop3f_url" value="{{ old('siscoop3f_url', $settings->siscoop3f_url) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">URL de Login da Telemedicina</label>
                    <input type="url" name="telemedicine_url" value="{{ old('telemedicine_url', $settings->telemedicine_url) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono">
                </div>
            </div>

            <div class="grid sm:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Telefone de Exibição</label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Número do WhatsApp (com DDI 55)</label>
                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $settings->whatsapp_number) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">E-mail de Contato</label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                </div>
            </div>
        </div>

        <!-- Bloco 3: Parâmetros do Simulador SISCOOP3F (Carta de Intenção) -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-5">
            <h2 class="font-brand text-lg font-extrabold text-[#022B5B] border-b border-slate-100 pb-3">
                3. Parâmetros do Simulador Interativo SISCOOP3F (Modelo de Investimento)
            </h2>

            <div class="grid sm:grid-cols-5 gap-4">
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Dias de Testes Grátis</label>
                    <input type="number" name="sim_trial_days" value="{{ old('sim_trial_days', $settings->sim_trial_days) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">% Economia (IS)</label>
                    <input type="number" name="sim_savings_share_percent" value="{{ old('sim_savings_share_percent', $settings->sim_savings_share_percent) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">% Novas Receitas (IS)</label>
                    <input type="number" name="sim_revenue_share_percent" value="{{ old('sim_revenue_share_percent', $settings->sim_revenue_share_percent) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Valor Normal/Usuário (R$)</label>
                    <input type="number" step="0.01" name="sim_user_regular_price" value="{{ old('sim_user_regular_price', $settings->sim_user_regular_price) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Valor Parceria 50% (R$)</label>
                    <input type="number" step="0.01" name="sim_user_partner_price" value="{{ old('sim_user_partner_price', $settings->sim_user_partner_price) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                </div>
            </div>
        </div>

        <!-- Bloco 4: Rodapé -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-5">
            <h2 class="font-brand text-lg font-extrabold text-[#022B5B] border-b border-slate-100 pb-3">
                4. Textos do Rodapé Institucional
            </h2>

            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Descrição Institucional no Rodapé</label>
                <textarea name="footer_description" rows="2" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm">{{ old('footer_description', $settings->footer_description) }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Texto de Copyright</label>
                <input type="text" name="footer_copyright" value="{{ old('footer_copyright', $settings->footer_copyright) }}" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm">
            </div>
        </div>

        <!-- Bloco 5: SEO Técnico, Metadados Google & Compartilhamento Social -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-5">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-3">
                <div>
                    <h2 class="font-brand text-lg font-extrabold text-[#022B5B]">
                        5. SEO & Metadados para o Google, WhatsApp e Redes Sociais
                    </h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Configure como o site aparece nos resultados de pesquisa do Google e quando o link é enviado no WhatsApp/LinkedIn.
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('portal.sitemap') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-sky-50 hover:bg-sky-100 text-[#00509D] border border-sky-200 text-xs font-brand font-bold transition">
                        Ver sitemap.xml ↗
                    </a>
                    <a href="{{ route('portal.robots') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-brand font-bold transition">
                        Ver robots.txt ↗
                    </a>
                </div>
            </div>

            <!-- Pré-visualização em Tempo Real do Resultado no Google -->
            <div class="p-4 sm:p-5 rounded-2xl bg-[#F8FAFC] border border-slate-200 space-y-1">
                <span class="text-[10px] font-brand font-bold uppercase tracking-widest text-slate-400 block mb-1">
                    Pré-visualização no Google (Snippet de Busca)
                </span>
                <div class="text-xs text-emerald-700 font-mono truncate">{{ rtrim(url('/'), '/') }}/</div>
                <div class="text-base sm:text-lg font-semibold text-[#1a0dab] hover:underline truncate">
                    {{ $settings->seo_title ?: ($settings->brand_part_1 . $settings->brand_part_2 . ' — ' . $settings->brand_tagline) }}
                </div>
                <div class="text-xs sm:text-sm text-slate-600 line-clamp-2 leading-relaxed max-w-2xl">
                    {{ $settings->seo_description ?: $settings->footer_description }}
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">
                        Título de SEO (Meta Title — Ideal entre 50 e 70 caracteres)
                    </label>
                    <input
                        type="text"
                        name="seo_title"
                        value="{{ old('seo_title', $settings->seo_title) }}"
                        placeholder="Ex: IntegreService (IS) — Gestão Cooperativista (SISCOOP3F), Telemedicina 24/7 & Consultoria"
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-semibold text-[#022B5B]"
                    >
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">
                        Descrição de SEO para o Google & WhatsApp (Meta Description — Ideal até 160 caracteres)
                    </label>
                    <textarea
                        name="seo_description"
                        rows="2"
                        placeholder="Resumo claro e atrativo que aparece no Google e no card do WhatsApp..."
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm"
                    >{{ old('seo_description', $settings->seo_description) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">
                        Palavras-Chave Estratégicas (Meta Keywords — Separadas por vírgula)
                    </label>
                    <input
                        type="text"
                        name="seo_keywords"
                        value="{{ old('seo_keywords', $settings->seo_keywords) }}"
                        placeholder="IntegreService, SISCOOP3F, gestão de cooperativas, telemedicina 24h, consultoria executiva..."
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm"
                    >
                </div>

                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">
                        Imagem de Compartilhamento (Open Graph / WhatsApp)
                    </label>
                    <input
                        type="text"
                        name="og_image_path"
                        value="{{ old('og_image_path', $settings->og_image_path ?: '/assets/images/logo-icon.png') }}"
                        class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono"
                    >
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">
                            Google Search Console (Código)
                        </label>
                        <input
                            type="text"
                            name="google_verification_code"
                            value="{{ old('google_verification_code', $settings->google_verification_code) }}"
                            placeholder="Opcional"
                            class="w-full px-3.5 py-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-mono"
                        >
                    </div>
                    <div>
                        <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">
                            Google Analytics (ID G-XXXX)
                        </label>
                        <input
                            type="text"
                            name="google_analytics_id"
                            value="{{ old('google_analytics_id', $settings->google_analytics_id) }}"
                            placeholder="Ex: G-XXXXXXXXXX"
                            class="w-full px-3.5 py-3 rounded-xl bg-slate-50 border border-slate-200 text-xs font-mono"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-4 rounded-2xl font-brand font-bold text-xs uppercase tracking-wider text-white bg-gradient-to-r from-[#022B5B] via-[#00509D] to-[#00B4D8] shadow-lg hover:opacity-95 transition cursor-pointer">
                Salvar Todas as Configurações & SEO
            </button>
        </div>
    </form>
@endsection
