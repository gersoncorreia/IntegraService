@extends('admin.layout')

@section('title', 'Editar: ' . ($section->nav_label ?: $section->section_key))
@section('header', 'Editando: ' . ($section->nav_label ?: $section->section_key))
@section('subheader', 'Altere os títulos, subtítulos, configurações da aba e gerencie os cards de diferenciais exibidos nesta seção.')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.sections.index') }}" class="inline-flex items-center gap-2 text-xs font-brand font-bold text-[#022B5B] hover:text-[#0077B6]">
            <span>← Voltar para Frentes de Atuação & Seções</span>
        </a>

        @if(!in_array($section->section_key, \App\Models\PageSection::STRUCTURAL_KEYS, true))
            <form action="{{ route('admin.sections.destroy', $section) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta Frente de Atuação permanentemente? Se quiser apenas escondê-la temporariamente, basta desmarcar a opção Exibir no Portal.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3.5 py-2 rounded bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-brand font-bold transition cursor-pointer">
                    Excluir Frente de Atuação
                </button>
            </form>
        @endif
    </div>

    <!-- Formulário Principal da Seção / Frente de Atuação -->
    <form action="{{ route('admin.sections.update', $section) }}" method="POST" class="bg-white rounded-lg border border-slate-200 p-6 sm:p-8 shadow-xs space-y-5">
        @csrf
        @method('PUT')

        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 pb-4">
            <div>
                <span class="text-xs font-mono text-slate-400">Identificador: #{{ $section->section_key }}</span>
                <h2 class="font-brand text-lg font-extrabold text-[#022B5B]">
                    {{ $section->isEcosystemTab() ? 'Configurações da Aba & Textos da Frente de Atuação' : 'Textos Principais e Botões da Seção' }}
                </h2>
            </div>

            <label class="inline-flex items-center gap-2.5 cursor-pointer bg-emerald-50/80 px-4 py-2.5 rounded border border-emerald-200">
                <input type="checkbox" name="is_active" value="1" {{ $section->is_active ? 'checked' : '' }} class="w-4 h-4 accent-[#022B5B]">
                <span class="text-xs font-brand font-bold text-[#022B5B]">Habilitado (Visível na Página Pública)</span>
            </label>
        </div>

        @if($section->isEcosystemTab())
            @php $tabMeta = $section->getTabMeta(); @endphp
            <div class="p-5 rounded-md bg-[#F4F8FB] border border-slate-200 border-l-4 border-l-[#00509D] space-y-4">
                <h3 class="font-brand text-xs font-bold uppercase tracking-wider text-[#00509D]">
                    Configuração do Botão da Aba (Em "Nossas Frentes de Atuação")
                </h3>
                <div class="grid sm:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Título na Aba *</label>
                        <input type="text" name="tab_title" value="{{ old('tab_title', $tabMeta['tab_title']) }}" required class="w-full px-3.5 py-2.5 rounded bg-white border border-slate-300 text-sm font-bold text-[#022B5B]">
                    </div>
                    <div>
                        <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Subtítulo na Aba *</label>
                        <input type="text" name="tab_subtitle" value="{{ old('tab_subtitle', $tabMeta['tab_subtitle']) }}" required class="w-full px-3.5 py-2.5 rounded bg-white border border-slate-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Ícone da Aba</label>
                        <select name="tab_icon" class="w-full px-3.5 py-2.5 rounded bg-white border border-slate-300 text-sm">
                            @foreach(['network','video','heart-pulse','chart-bar','book-open','sparkles','shield-check','cpu','bolt','device-mobile','trending-up','users','clock','document-check','briefcase','academic-cap'] as $ic)
                                <option value="{{ $ic }}" {{ $tabMeta['tab_icon'] === $ic ? 'selected' : '' }}>{{ $ic }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Tema Visual da Aba</label>
                        <select name="tab_theme" class="w-full px-3.5 py-2.5 rounded bg-white border border-slate-300 text-sm font-semibold">
                            <option value="light" {{ $tabMeta['tab_theme'] === 'light' ? 'selected' : '' }}>Claro (Fundo Branco)</option>
                            <option value="dark" {{ $tabMeta['tab_theme'] === 'dark' ? 'selected' : '' }}>Escuro (Azul Marinho)</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="tab_type" value="{{ $tabMeta['tab_type'] }}">
            </div>
        @endif

        <div class="grid sm:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Nome Interno / Menu</label>
                <input type="text" name="nav_label" value="{{ old('nav_label', $section->nav_label) }}" class="w-full px-3.5 py-2.5 rounded bg-slate-50 border border-slate-300 text-sm">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Etiqueta Superior (Badge)</label>
                <input type="text" name="badge_text" value="{{ old('badge_text', $section->badge_text) }}" class="w-full px-3.5 py-2.5 rounded bg-slate-50 border border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Ordem de Exibição</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $section->sort_order) }}" class="w-full px-3.5 py-2.5 rounded bg-slate-50 border border-slate-300 text-sm">
            </div>
        </div>

        <input type="hidden" name="palette" value="{{ $section->palette ?: 'paleta_01' }}">

        <div class="grid sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Título Principal</label>
                <input type="text" name="title" value="{{ old('title', $section->title) }}" class="w-full px-3.5 py-2.5 rounded bg-slate-50 border border-slate-300 text-sm font-bold text-[#022B5B]">
            </div>
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Palavra/Frase em Destaque Colorido</label>
                <input type="text" name="highlighted_word" value="{{ old('highlighted_word', $section->highlighted_word) }}" class="w-full px-3.5 py-2.5 rounded bg-slate-50 border border-slate-300 text-sm font-bold text-[#0077B6]">
            </div>
        </div>

        <div>
            <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Subtítulo / Parágrafo Explicativo</label>
            <textarea name="subtitle" rows="2" class="w-full px-3.5 py-2.5 rounded bg-slate-50 border border-slate-300 text-sm">{{ old('subtitle', $section->subtitle) }}</textarea>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Texto do Botão Principal</label>
                <input type="text" name="primary_cta_text" value="{{ old('primary_cta_text', $section->primary_cta_text) }}" class="w-full px-3.5 py-2.5 rounded bg-slate-50 border border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Link do Botão Principal (ou #contato)</label>
                <input type="text" name="primary_cta_url" value="{{ old('primary_cta_url', $section->primary_cta_url) }}" class="w-full px-3.5 py-2.5 rounded bg-slate-50 border border-slate-300 text-sm font-mono">
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Texto do Botão Secundário</label>
                <input type="text" name="secondary_cta_text" value="{{ old('secondary_cta_text', $section->secondary_cta_text) }}" class="w-full px-3.5 py-2.5 rounded bg-slate-50 border border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Link do Botão Secundário</label>
                <input type="text" name="secondary_cta_url" value="{{ old('secondary_cta_url', $section->secondary_cta_url) }}" class="w-full px-3.5 py-2.5 rounded bg-slate-50 border border-slate-300 text-sm font-mono">
            </div>
        </div>

        @if($section->section_key === 'hero')
            @php $extra = $section->extra_data ?? []; @endphp
            <div class="p-5 rounded-md bg-sky-50/70 border border-sky-200 space-y-4">
                <h3 class="font-brand text-xs font-bold uppercase tracking-wider text-[#00509D]">1. Os 3 Indicadores Rápidos do Hero Header</h3>
                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <input type="text" name="stat_1_value" value="{{ $extra['stat_1_value'] ?? '4 Soluções' }}" placeholder="Valor 1" class="w-full px-3 py-2 rounded bg-white border border-slate-300 text-xs font-bold mb-1">
                        <input type="text" name="stat_1_label" value="{{ $extra['stat_1_label'] ?? 'Ecossistema Integrado' }}" placeholder="Legenda 1" class="w-full px-3 py-2 rounded bg-white border border-slate-300 text-xs">
                    </div>
                    <div>
                        <input type="text" name="stat_2_value" value="{{ $extra['stat_2_value'] ?? '3 Públicos' }}" placeholder="Valor 2" class="w-full px-3 py-2 rounded bg-white border border-slate-300 text-xs font-bold mb-1">
                        <input type="text" name="stat_2_label" value="{{ $extra['stat_2_label'] ?? 'Cooperativas, Privado e Público' }}" placeholder="Legenda 2" class="w-full px-3 py-2 rounded bg-white border border-slate-300 text-xs">
                    </div>
                    <div>
                        <input type="text" name="stat_3_value" value="{{ $extra['stat_3_value'] ?? '30 Dias*' }}" placeholder="Valor 3" class="w-full px-3 py-2 rounded bg-white border border-slate-300 text-xs font-bold mb-1">
                        <input type="text" name="stat_3_label" value="{{ $extra['stat_3_label'] ?? 'Avaliação Assistida SISCOOP3F' }}" placeholder="Legenda 3" class="w-full px-3 py-2 rounded bg-white border border-slate-300 text-xs">
                    </div>
                </div>

                <h3 class="font-brand text-xs font-bold uppercase tracking-wider text-[#00509D] pt-2 border-t border-sky-200/80">
                    2. Caminhos Rápidos por Público-Alvo (Cooperativas, Saúde Privada e Gestão Pública)
                </h3>
                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="space-y-1.5">
                        <input type="text" name="audience_1_title" value="{{ $extra['audience_1_title'] ?? 'Para Cooperativas' }}" class="w-full px-3 py-2 rounded bg-white border border-slate-300 text-xs font-bold">
                        <textarea name="audience_1_desc" rows="2" class="w-full px-3 py-2 rounded bg-white border border-slate-300 text-xs">{{ $extra['audience_1_desc'] ?? '' }}</textarea>
                    </div>
                    <div class="space-y-1.5">
                        <input type="text" name="audience_2_title" value="{{ $extra['audience_2_title'] ?? 'Para Saúde Privada & Empresas' }}" class="w-full px-3 py-2 rounded bg-white border border-slate-300 text-xs font-bold">
                        <textarea name="audience_2_desc" rows="2" class="w-full px-3 py-2 rounded bg-white border border-slate-300 text-xs">{{ $extra['audience_2_desc'] ?? '' }}</textarea>
                    </div>
                    <div class="space-y-1.5">
                        <input type="text" name="audience_3_title" value="{{ $extra['audience_3_title'] ?? 'Para Gestão Pública' }}" class="w-full px-3 py-2 rounded bg-white border border-slate-300 text-xs font-bold">
                        <textarea name="audience_3_desc" rows="2" class="w-full px-3 py-2 rounded bg-white border border-slate-300 text-xs">{{ $extra['audience_3_desc'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        @elseif($section->section_key === 'institutional_identity')
            @php $extra = $section->extra_data ?? []; @endphp
            <div class="p-5 rounded-md bg-[#F4F8FB] border border-slate-200 border-l-4 border-l-[#022B5B] space-y-4">
                <h3 class="font-brand text-xs font-bold uppercase tracking-wider text-[#022B5B]">
                    1. Diretrizes Institucionais (Razão de Existir, Missão, Visão e Valores)
                </h3>

                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-[#00509D] mb-1">Título: Razão de Existir</label>
                    <input type="text" name="purpose_label" value="{{ $extra['purpose_label'] ?? 'Razão de Existir' }}" class="w-full px-3.5 py-2 rounded bg-white border border-slate-300 text-xs font-bold mb-2">
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">Texto da Razão de Existir</label>
                    <textarea name="purpose_text" rows="2" class="w-full px-3.5 py-2.5 rounded bg-white border border-slate-300 text-sm">{{ $extra['purpose_text'] ?? '' }}</textarea>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-brand font-bold uppercase text-[#00509D] mb-1">Título: Missão</label>
                        <input type="text" name="mission_label" value="{{ $extra['mission_label'] ?? 'Missão' }}" class="w-full px-3.5 py-2 rounded bg-white border border-slate-300 text-xs font-bold mb-2">
                        <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">Texto da Missão</label>
                        <textarea name="mission_text" rows="3" class="w-full px-3.5 py-2.5 rounded bg-white border border-slate-300 text-sm">{{ $extra['mission_text'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-brand font-bold uppercase text-[#00509D] mb-1">Título: Visão</label>
                        <input type="text" name="vision_label" value="{{ $extra['vision_label'] ?? 'Visão' }}" class="w-full px-3.5 py-2 rounded bg-white border border-slate-300 text-xs font-bold mb-2">
                        <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">Texto da Visão</label>
                        <textarea name="vision_text" rows="3" class="w-full px-3.5 py-2.5 rounded bg-white border border-slate-300 text-sm">{{ $extra['vision_text'] ?? '' }}</textarea>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-[#00509D] mb-1">Título: Valores</label>
                    <input type="text" name="values_label" value="{{ $extra['values_label'] ?? 'Valores Institucionais' }}" class="w-full px-3.5 py-2 rounded bg-white border border-slate-300 text-xs font-bold mb-2">
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">Lista de Valores (separados por vírgula)</label>
                    <textarea name="values_text" rows="2" class="w-full px-3.5 py-2.5 rounded bg-white border border-slate-300 text-sm">{{ $extra['values_text'] ?? '' }}</textarea>
                </div>

                <div class="pt-4 border-t border-slate-200 space-y-3">
                    <h3 class="font-brand text-xs font-bold uppercase tracking-wider text-[#022B5B]">
                        2. Liderança e Relacionamento Institucional (Eudemir Bezerra)
                    </h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">Etiqueta Superior da Liderança</label>
                            <input type="text" name="leadership_badge" value="{{ $extra['leadership_badge'] ?? 'LIDERANÇA E RELACIONAMENTO INSTITUCIONAL' }}" class="w-full px-3.5 py-2 rounded bg-white border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">Título & Cargo da Liderança</label>
                            <input type="text" name="leadership_title" value="{{ $extra['leadership_title'] ?? 'Eudemir Bezerra | Direção Executiva - IntegreService' }}" class="w-full px-3.5 py-2 rounded bg-white border border-slate-300 text-xs font-bold">
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">1º Parágrafo de Atuação</label>
                            <textarea name="leadership_bio_1" rows="3" class="w-full px-3.5 py-2 rounded bg-white border border-slate-300 text-xs">{{ $extra['leadership_bio_1'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">2º Parágrafo de Atuação</label>
                            <textarea name="leadership_bio_2" rows="3" class="w-full px-3.5 py-2 rounded bg-white border border-slate-300 text-xs">{{ $extra['leadership_bio_2'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">Texto do Botão da Liderança</label>
                        <input type="text" name="leadership_cta_text" value="{{ $extra['leadership_cta_text'] ?? 'Falar com a direção executiva' }}" class="w-full px-3.5 py-2 rounded bg-white border border-slate-300 text-xs">
                    </div>
                </div>
            </div>
        @elseif($section->section_key === 'implementation_plan')
            @php $extra = $section->extra_data ?? []; @endphp
            <div class="p-5 rounded-md bg-[#F4F8FB] border border-slate-200 border-l-4 border-l-[#00509D] space-y-4">
                <h3 class="font-brand text-xs font-bold uppercase tracking-wider text-[#00509D]">
                    Configurações da Jornada Comercial & Condições de Implantação
                </h3>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">Subtítulo da Grade de Etapas</label>
                    <input type="text" name="journey_title" value="{{ $extra['journey_title'] ?? 'Jornada Comercial Recomendada em 5 Etapas' }}" class="w-full px-3.5 py-2 rounded bg-white border border-slate-300 text-xs font-bold">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">Nota de Transparência sobre Prazos, Escopo e Condições Comerciais</label>
                    <textarea name="commercial_note" rows="2" class="w-full px-3.5 py-2.5 rounded bg-white border border-slate-300 text-sm">{{ $extra['commercial_note'] ?? '' }}</textarea>
                </div>
            </div>
        @elseif($section->section_key === 'investment_model')
            @php $extra = $section->extra_data ?? []; @endphp
            <div class="p-5 rounded-md bg-[#F4F8FB] border border-slate-200 border-l-4 border-l-[#022B5B] space-y-4">
                <h3 class="font-brand text-xs font-bold uppercase tracking-wider text-[#022B5B]">
                    Textos do Simulador Financeiro, Memória de Cálculo & Ressalvas Legais
                </h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">Título Interno do Simulador</label>
                        <input type="text" name="simulator_title" value="{{ $extra['simulator_title'] ?? 'Simule o potencial de eficiência da sua cooperativa' }}" class="w-full px-3.5 py-2 rounded bg-white border border-slate-300 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">Texto do Botão do Simulador</label>
                        <input type="text" name="simulator_cta_text" value="{{ $extra['simulator_cta_text'] ?? 'Solicitar análise personalizada' }}" class="w-full px-3.5 py-2 rounded bg-white border border-slate-300 text-xs font-bold">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">Instrução Inicial do Simulador</label>
                    <textarea name="simulator_subtitle" rows="2" class="w-full px-3.5 py-2 rounded bg-white border border-slate-300 text-xs">{{ $extra['simulator_subtitle'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-amber-800 mb-1">Aviso Legal Obrigatório (Projeção Ilustrativa / Não Garantia de Economia)</label>
                    <textarea name="disclaimer_text" rows="2" class="w-full px-3.5 py-2 rounded bg-white border border-amber-300 text-xs">{{ $extra['disclaimer_text'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">Nota Contratual sobre Remuneração por Desempenho</label>
                    <input type="text" name="contract_note" value="{{ $extra['contract_note'] ?? '' }}" class="w-full px-3.5 py-2 rounded bg-white border border-slate-300 text-xs">
                </div>
            </div>
        @elseif($section->section_key === 'public_management')
            @php $extra = $section->extra_data ?? []; @endphp
            <div class="p-5 rounded-md bg-[#F4F8FB] border border-slate-200 border-l-4 border-l-[#0077B6] space-y-4">
                <h3 class="font-brand text-xs font-bold uppercase tracking-wider text-[#0077B6]">
                    Conformidade Regulatória para Contratações Públicas
                </h3>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1">Nota Legal e Regulatória (Exibida no Rodapé da Seção de Gestão Pública)</label>
                    <textarea name="regulatory_note" rows="2" class="w-full px-3.5 py-2.5 rounded bg-white border border-slate-300 text-sm">{{ $extra['regulatory_note'] ?? '' }}</textarea>
                </div>
            </div>
        @endif

        <div class="flex justify-end pt-2">
            <button type="submit" class="px-7 py-3.5 rounded font-brand font-bold text-xs uppercase tracking-wider text-white bg-[#022B5B] hover:bg-[#00509D] border-b-2 border-[#00E5FF] shadow-sm transition cursor-pointer">
                Salvar Alterações desta Seção →
            </button>
        </div>
    </form>

    <!-- Gestão dos Cards / Diferenciais Internos da Seção -->
    <div class="space-y-4 pt-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-brand text-lg font-extrabold text-[#022B5B]">Cards e Diferenciais Desta Seção ({{ $section->items->count() }})</h2>
                <p class="text-xs text-slate-500">Estes são os cards exibidos ao lado direito da aba ou nos blocos da seção.</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            @foreach($section->items as $item)
                <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-xs space-y-4">
                    <form action="{{ route('admin.sections.items.update', $item) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                            <span class="text-xs font-brand font-bold text-[#0077B6]">Card #{{ $loop->iteration }}</span>
                            <label class="inline-flex items-center gap-1.5 text-xs font-semibold">
                                <input type="checkbox" name="is_active" value="1" {{ $item->is_active ? 'checked' : '' }} class="accent-[#022B5B]">
                                <span>Visível</span>
                            </label>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Badge Superior</label>
                                <input type="text" name="badge" value="{{ $item->badge }}" class="w-full px-3 py-2 rounded bg-slate-50 border border-slate-300 text-xs">
                            </div>
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Selo / Métrica Lateral</label>
                                <input type="text" name="highlight_metric" value="{{ $item->highlight_metric }}" class="w-full px-3 py-2 rounded bg-slate-50 border border-slate-300 text-xs font-bold text-[#0077B6]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Título do Card *</label>
                            <input type="text" name="title" value="{{ $item->title }}" required class="w-full px-3 py-2 rounded bg-slate-50 border border-slate-300 text-xs font-bold text-[#022B5B]">
                        </div>

                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Descrição</label>
                            <textarea name="description" rows="2" class="w-full px-3 py-2 rounded bg-slate-50 border border-slate-300 text-xs">{{ $item->description }}</textarea>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Ícone</label>
                                <select name="icon" class="w-full px-2.5 py-2 rounded bg-slate-50 border border-slate-300 text-xs">
                                    @foreach(['shield-check','cpu','bolt','network','video','heart-pulse','chart-bar','book-open','device-mobile','trending-up','users','clock','document-check','briefcase','academic-cap','sparkles'] as $ic)
                                        <option value="{{ $ic }}" {{ $item->icon === $ic ? 'selected' : '' }}>{{ $ic }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Cor de Acento</label>
                                <select name="accent_color" class="w-full px-2.5 py-2 rounded bg-slate-50 border border-slate-300 text-xs">
                                    @foreach(['cyan','royal','turquoise','electric'] as $col)
                                        <option value="{{ $col }}" {{ $item->accent_color === $col ? 'selected' : '' }}>{{ ucfirst($col) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Ordem</label>
                                <input type="number" name="sort_order" value="{{ $item->sort_order }}" class="w-full px-3 py-2 rounded bg-slate-50 border border-slate-300 text-xs">
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <button type="submit" class="px-4 py-2 rounded bg-[#022B5B] hover:bg-[#00509D] text-white text-xs font-brand font-bold transition cursor-pointer">
                                Salvar Card
                            </button>
                        </div>
                    </form>

                    <form action="{{ route('admin.sections.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Deseja remover este card?')" class="border-t border-slate-100 pt-2 flex justify-end">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-rose-600 hover:underline font-semibold cursor-pointer">Excluir Card</button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Adicionar Novo Card na Seção -->
        <form action="{{ route('admin.sections.items.store', $section) }}" method="POST" class="bg-[#01162E] text-white rounded-lg p-6 sm:p-8 space-y-4">
            @csrf
            <h3 class="font-brand text-base font-extrabold text-[#00E5FF]">+ Adicionar Novo Card / Diferencial nesta Seção</h3>
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Título do Card *</label>
                    <input type="text" name="title" required placeholder="Ex: Atendimento Humanizado" class="w-full px-3.5 py-2.5 rounded bg-white/10 border border-white/15 text-sm text-white">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Selo Lateral (Métrica)</label>
                    <input type="text" name="highlight_metric" placeholder="Ex: HD 24/7 ou 100% LEGAL" class="w-full px-3.5 py-2.5 rounded bg-white/10 border border-white/15 text-sm text-white">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Ícone</label>
                    <select name="icon" class="w-full px-3.5 py-2.5 rounded bg-[#022B5B] border border-white/15 text-sm text-white">
                        @foreach(['sparkles','shield-check','cpu','bolt','network','video','heart-pulse','chart-bar','book-open','device-mobile','trending-up','users','clock','document-check','briefcase','academic-cap'] as $ic)
                            <option value="{{ $ic }}">{{ $ic }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Descrição do Card</label>
                <input type="text" name="description" placeholder="Texto explicativo do diferencial..." class="w-full px-3.5 py-2.5 rounded bg-white/10 border border-white/15 text-sm text-white">
            </div>

            <input type="hidden" name="badge" value="DIFERENCIAL">
            <input type="hidden" name="accent_color" value="cyan">
            <input type="hidden" name="sort_order" value="{{ $section->items->count() + 1 }}">

            <button type="submit" class="px-6 py-3 rounded font-brand font-bold text-xs uppercase tracking-wider text-[#01162E] bg-[#00E5FF] hover:bg-[#80FFDB] transition cursor-pointer">
                Adicionar Card à Seção →
            </button>
        </form>
    </div>
@endsection
