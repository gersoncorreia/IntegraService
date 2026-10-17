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

        <div class="flex justify-end">
            <button type="submit" class="px-8 py-4 rounded-2xl font-brand font-bold text-xs uppercase tracking-wider text-white bg-gradient-to-r from-[#022B5B] via-[#00509D] to-[#00B4D8] shadow-lg hover:opacity-95 transition">
                Salvar Todas as Configurações Globais
            </button>
        </div>
    </form>
@endsection
