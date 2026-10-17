@extends('admin.layout')

@section('title', 'Frentes de Atuação & Seções do Portal')
@section('header', 'Gerenciar Frentes de Atuação (Abas) & Seções do Portal')
@section('subheader', 'Habilite ou oculte quais Frentes de Atuação aparecem na página, crie novas frentes e edite os textos de cada seção.')

@section('content')
    <!-- =======================================================================
         PARTE 1: NOSSAS FRENTES DE ATUAÇÃO (ABAS INTERATIVAS DO ECOSSISTEMA)
         ======================================================================= -->
    <div class="bg-white rounded-lg border border-slate-200 shadow-xs overflow-hidden">
        <div class="h-1 w-full bg-gradient-to-r from-[#022B5B] via-[#00509D] to-[#00E5FF]"></div>

        <div class="p-6 sm:p-8 space-y-6">
            <div class="flex flex-wrap items-center justify-between gap-4 pb-5 border-b border-slate-200">
                <div>
                    <span class="inline-block px-2.5 py-1 rounded-xs bg-[#022B5B]/10 text-[#022B5B] font-brand font-bold text-[10px] uppercase tracking-widest mb-1.5">
                        SEÇÃO: NOSSAS FRENTES DE ATUAÇÃO (ABAS DINÂMICAS)
                    </span>
                    <h2 class="font-brand text-xl sm:text-2xl font-extrabold text-[#022B5B]">
                        Frentes de Atuação que Aparecem na Página ({{ $ecosystemTabs->where('is_active', true)->count() }} ativas de {{ $ecosystemTabs->count() }})
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1">
                        Use o botão <strong>Habilitar / Ocultar</strong> para escolher quais frentes aparecem na barra de abas do portal ou clique em <strong>"+ Adicionar Nova Frente"</strong> abaixo.
                    </p>
                </div>

                <a
                    href="#form-nova-frente"
                    class="px-5 py-3 rounded font-brand font-bold text-xs uppercase tracking-wider text-white bg-[#022B5B] hover:bg-[#00509D] border-b-2 border-[#00E5FF] transition"
                >
                    + Adicionar Nova Frente de Atuação
                </a>
            </div>

            <!-- Grid das Frentes de Atuação Cadastradas -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($ecosystemTabs as $idx => $tabSection)
                    @php
                        $tabMeta = $tabSection->getTabMeta();
                    @endphp
                    <div class="rounded-md border {{ $tabSection->is_active ? 'bg-white border-slate-200 border-l-4 border-l-[#022B5B]' : 'bg-slate-50 border-slate-200/80 opacity-75' }} p-5 flex flex-col justify-between shadow-2xs">
                        <div>
                            <!-- Topo: Número + Status + Toggle 1-Clique -->
                            <div class="flex items-center justify-between gap-2 pb-3 mb-3 border-b border-slate-100">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono text-xs font-bold px-2 py-0.5 rounded-xs bg-[#022B5B] text-[#00E5FF]">
                                        Aba {{ str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-xs text-[10px] font-brand font-bold uppercase {{ $tabSection->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                        {{ $tabSection->is_active ? 'Habilitada no Site' : 'Oculta no Site' }}
                                    </span>
                                </div>

                                <!-- Botão Rápido Habilitar / Desabilitar com 1 Clique -->
                                <form action="{{ route('admin.sections.toggle', $tabSection) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        class="px-2.5 py-1 rounded text-[11px] font-brand font-bold border transition cursor-pointer {{ $tabSection->is_active ? 'bg-amber-50 text-amber-800 border-amber-200 hover:bg-amber-100' : 'bg-emerald-600 text-white border-emerald-600 hover:bg-emerald-500' }}"
                                    >
                                        {{ $tabSection->is_active ? 'Ocultar' : 'Habilitar' }}
                                    </button>
                                </form>
                            </div>

                            <!-- Nome e Subtítulo da Aba -->
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="font-brand text-lg font-extrabold text-[#022B5B]">
                                        {{ $tabMeta['tab_title'] }}
                                    </h3>
                                    <span class="text-xs font-semibold text-[#0077B6] block">
                                        Subtítulo na Aba: {{ $tabMeta['tab_subtitle'] }}
                                    </span>
                                </div>
                                <span class="px-2 py-1 rounded-xs bg-slate-100 text-slate-600 font-mono text-[10px] uppercase">
                                    Tema: {{ $tabMeta['tab_theme'] === 'dark' ? 'Escuro' : 'Claro' }}
                                </span>
                            </div>

                            <p class="text-xs text-slate-600 mt-3 line-clamp-2 leading-relaxed">
                                <strong>Título Interno:</strong> {{ $tabSection->title }} <span class="text-[#0077B6] font-bold">{{ $tabSection->highlighted_word }}</span>
                            </p>
                        </div>

                        <div class="mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-between gap-2">
                            <span class="text-[11px] font-brand font-bold text-slate-500">
                                @if($tabMeta['tab_type'] === 'clinic')
                                    Usa Departamentos da Clínica
                                @elseif($tabMeta['tab_type'] === 'book')
                                    Usa Livro em Destaque
                                @else
                                    {{ $tabSection->items->count() }} cards de diferenciais
                                @endif
                            </span>

                            <div class="flex items-center gap-2">
                                <a
                                    href="{{ route('admin.sections.edit', $tabSection) }}"
                                    class="px-3.5 py-2 rounded bg-[#022B5B] hover:bg-[#00509D] text-white text-xs font-brand font-bold transition"
                                >
                                    Editar Conteúdo & Cards →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Formulário para Adicionar Nova Frente de Atuação (Nova Aba no Ecossistema) -->
            <div id="form-nova-frente" class="mt-8 rounded-lg bg-[#01162E] text-white border border-cyan-500/30 p-6 sm:p-8">
                <div class="pb-4 mb-5 border-b border-white/10 flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <span class="text-[10px] font-brand font-bold uppercase tracking-[0.14em] text-[#00E5FF] block">
                            EXPANSÃO DO ECOSSISTEMA
                        </span>
                        <h3 class="font-brand text-lg sm:text-xl font-extrabold text-white mt-0.5">
                            + Adicionar Nova Frente de Atuação (Nova Aba na Página)
                        </h3>
                    </div>
                    <span class="text-xs text-slate-300">
                        A nova frente aparecerá automaticamente nas abas e no formulário de proposta!
                    </span>
                </div>

                <form action="{{ route('admin.sections.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <!-- Linha 1: Dados da Aba Superior -->
                    <div class="grid sm:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-brand font-bold uppercase text-cyan-200 mb-1.5">
                                Nome da Aba (Curto) *
                            </label>
                            <input
                                type="text"
                                name="tab_title"
                                required
                                placeholder="Ex: Home Care"
                                class="w-full px-3.5 py-2.5 rounded bg-white/10 border border-white/20 text-sm text-white placeholder-slate-400"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-brand font-bold uppercase text-cyan-200 mb-1.5">
                                Subtítulo da Aba *
                            </label>
                            <input
                                type="text"
                                name="tab_subtitle"
                                required
                                placeholder="Ex: Atenção Domiciliar"
                                class="w-full px-3.5 py-2.5 rounded bg-white/10 border border-white/20 text-sm text-white placeholder-slate-400"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-brand font-bold uppercase text-cyan-200 mb-1.5">
                                Ícone da Aba *
                            </label>
                            <select name="tab_icon" class="w-full px-3.5 py-2.5 rounded bg-[#022B5B] border border-white/20 text-sm text-white">
                                @foreach(['sparkles','network','video','heart-pulse','chart-bar','book-open','shield-check','cpu','bolt','device-mobile','trending-up','users','clock','document-check','briefcase','academic-cap'] as $ic)
                                    <option value="{{ $ic }}">{{ $ic }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-brand font-bold uppercase text-cyan-200 mb-1.5">
                                Tema Visual do Painel *
                            </label>
                            <select name="tab_theme" class="w-full px-3.5 py-2.5 rounded bg-[#022B5B] border border-white/20 text-sm text-white">
                                <option value="dark">Escuro (Azul Marinho igual Telemedicina)</option>
                                <option value="light">Claro (Fundo Branco igual SISCOOP3F)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Linha 2: Título e Destaque dentro da Aba -->
                    <div class="grid sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-brand font-bold uppercase text-cyan-200 mb-1.5">
                                Etiqueta Superior (Badge)
                            </label>
                            <input
                                type="text"
                                name="badge_text"
                                placeholder="Ex: ATENDIMENTO DOMICILIAR INTEGRADO"
                                class="w-full px-3.5 py-2.5 rounded bg-white/10 border border-white/20 text-sm text-white placeholder-slate-400"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-brand font-bold uppercase text-cyan-200 mb-1.5">
                                Título Principal da Frente *
                            </label>
                            <input
                                type="text"
                                name="title"
                                required
                                placeholder="Ex: Assistência Domiciliar com"
                                class="w-full px-3.5 py-2.5 rounded bg-white/10 border border-white/20 text-sm text-white placeholder-slate-400"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-brand font-bold uppercase text-cyan-200 mb-1.5">
                                Palavra em Destaque Colorido
                            </label>
                            <input
                                type="text"
                                name="highlighted_word"
                                placeholder="Ex: Monitoramento 24h"
                                class="w-full px-3.5 py-2.5 rounded bg-white/10 border border-white/20 text-sm text-[#00E5FF] font-bold placeholder-slate-400"
                            >
                        </div>
                    </div>

                    <!-- Linha 3: Texto Explicativo e Botões -->
                    <div class="grid sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-brand font-bold uppercase text-cyan-200 mb-1.5">
                                Parágrafo Explicativo da Frente
                            </label>
                            <input
                                type="text"
                                name="subtitle"
                                placeholder="Descreva de forma clara e objetiva como funciona esta solução..."
                                class="w-full px-3.5 py-2.5 rounded bg-white/10 border border-white/20 text-sm text-white placeholder-slate-400"
                            >
                        </div>
                        <div>
                            <label class="block text-xs font-brand font-bold uppercase text-cyan-200 mb-1.5">
                                Texto do Botão Principal
                            </label>
                            <input
                                type="text"
                                name="primary_cta_text"
                                value="Solicitar Proposta Comercial"
                                class="w-full px-3.5 py-2.5 rounded bg-white/10 border border-white/20 text-sm text-white"
                            >
                        </div>
                    </div>

                    <!-- Linha 4: Primeiro Card de Diferencial (Opcional para já nascer preenchida) -->
                    <div class="p-4 rounded bg-white/[0.04] border border-white/10 space-y-3">
                        <span class="text-xs font-brand font-bold text-[#80FFDB] block">
                            1º Card de Diferencial desta Frente (Você poderá adicionar mais cards na tela seguinte):
                        </span>
                        <div class="grid sm:grid-cols-3 gap-4">
                            <div>
                                <input
                                    type="text"
                                    name="first_card_title"
                                    placeholder="Título do 1º Diferencial (Ex: Equipe Multidisciplinar)"
                                    class="w-full px-3 py-2 rounded bg-white/10 border border-white/15 text-xs text-white placeholder-slate-400"
                                >
                            </div>
                            <div>
                                <input
                                    type="text"
                                    name="first_card_metric"
                                    placeholder="Selo lateral (Ex: 24/7 ou 100% Digital)"
                                    class="w-full px-3 py-2 rounded bg-white/10 border border-white/15 text-xs text-white placeholder-slate-400"
                                >
                            </div>
                            <div>
                                <input
                                    type="text"
                                    name="first_card_description"
                                    placeholder="Breve descrição deste diferencial..."
                                    class="w-full px-3 py-2 rounded bg-white/10 border border-white/15 text-xs text-white placeholder-slate-400"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button
                            type="submit"
                            class="px-7 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider text-[#01162E] bg-[#00E5FF] hover:bg-[#80FFDB] transition cursor-pointer shadow-lg"
                        >
                            Criar e Habilitar Nova Frente de Atuação →
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- =======================================================================
         PARTE 2: SEÇÕES ESTRUTURAIS FIXAS DA PÁGINA (HERO, CABEÇALHO, SIMULADOR, CONTATO)
         ======================================================================= -->
    <div class="bg-white rounded-lg border border-slate-200 p-6 sm:p-8 shadow-xs space-y-6">
        <div>
            <span class="inline-block px-2.5 py-1 rounded-xs bg-slate-100 text-slate-700 font-brand font-bold text-[10px] uppercase tracking-widest mb-1.5">
                ESTRUTURA PRINCIPAL DA PÁGINA
            </span>
            <h2 class="font-brand text-xl sm:text-2xl font-extrabold text-[#022B5B]">
                Blocos & Seções Estruturais do Portal
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 mt-1">
                Edite o Topo (Hero Header), o título geral da seção "Nossas Frentes de Atuação", os 3 Pilares Econômicos do Simulador e a Seção de Contato.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            @foreach($structuralSections as $section)
                <div class="rounded-md border border-slate-200 p-5 flex flex-col justify-between bg-[#F8FAFC]">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="px-2.5 py-0.5 rounded-xs text-[10px] font-brand font-bold uppercase tracking-wider {{ $section->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                {{ $section->is_active ? 'Visível no Site' : 'Oculta' }}
                            </span>
                            <span class="text-xs font-mono text-slate-400">#{{ $section->section_key }}</span>
                        </div>

                        <h3 class="font-brand text-lg font-extrabold text-[#022B5B]">
                            @if($section->section_key === 'hero')
                                Topo Principal (Hero Header)
                            @elseif($section->section_key === 'ecosystem')
                                Cabeçalho Geral: "Nossas Frentes de Atuação"
                            @elseif($section->section_key === 'institutional_identity')
                                Identidade Institucional (Razão de Existir, Missão, Visão e Valores)
                            @elseif($section->section_key === 'investment_model')
                                Os 3 Pilares Econômicos (Acima do Simulador)
                            @elseif($section->section_key === 'contact')
                                Chamada Comercial & Formulário de Contato
                            @else
                                {{ $section->nav_label ?: ucfirst($section->section_key) }}
                            @endif
                        </h3>
                        <p class="text-xs font-semibold text-[#0077B6] mt-1">
                            {{ $section->badge_text }}
                        </p>
                        <p class="text-sm text-slate-600 mt-1.5 line-clamp-2">
                            {{ $section->title }} <strong class="text-[#022B5B]">{{ $section->highlighted_word }}</strong>
                        </p>
                    </div>

                    <div class="mt-5 pt-3.5 border-t border-slate-200/80 flex items-center justify-between">
                        <span class="text-xs font-brand font-bold text-slate-500">
                            {{ $section->items->count() }} subitens vinculados
                        </span>
                        <a href="{{ route('admin.sections.edit', $section) }}" class="px-4 py-2 rounded bg-[#022B5B] hover:bg-[#00509D] text-white text-xs font-brand font-bold transition">
                            Editar Textos →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
