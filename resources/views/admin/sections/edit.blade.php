@extends('admin.layout')

@section('title', 'Editar Seção: ' . ($section->nav_label ?: $section->section_key))
@section('header', 'Editando Seção: ' . ($section->nav_label ?: $section->section_key))
@section('subheader', 'Edite os textos principais da seção e gerencie todos os cards, pilares e diferenciais exibidos nela.')

@section('content')
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.sections.index') }}" class="text-xs font-brand font-bold text-[#0077B6] hover:underline">
            ← Voltar para Todas as Seções
        </a>
    </div>

    <!-- Formulário Principal da Seção -->
    <form action="{{ route('admin.sections.update', $section) }}" method="POST" class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-5">
        @csrf
        @method('PUT')

        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <span class="text-xs font-mono text-slate-400">Chave da Seção: #{{ $section->section_key }}</span>
                <h2 class="font-brand text-lg font-extrabold text-[#022B5B]">Textos Principais, Paleta e Botões (CTAs)</h2>
            </div>

            <label class="inline-flex items-center gap-2.5 cursor-pointer bg-slate-50 px-4 py-2 rounded-xl border border-slate-200">
                <input type="checkbox" name="is_active" value="1" {{ $section->is_active ? 'checked' : '' }} class="w-4 h-4 accent-[#00B4D8]">
                <span class="text-xs font-brand font-bold text-[#022B5B]">Exibir esta seção no portal</span>
            </label>
        </div>

        <div class="grid sm:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Nome no Menu</label>
                <input type="text" name="nav_label" value="{{ old('nav_label', $section->nav_label) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Badge Superior (Etiqueta de Destaque)</label>
                <input type="text" name="badge_text" value="{{ old('badge_text', $section->badge_text) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm">
            </div>
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Paleta Oficial</label>
                <select name="palette" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-semibold">
                    <option value="paleta_01" {{ $section->palette === 'paleta_01' ? 'selected' : '' }}>Paleta 01 (Royal & Cyan)</option>
                    <option value="paleta_02" {{ $section->palette === 'paleta_02' ? 'selected' : '' }}>Paleta 02 (Saúde Turquesa)</option>
                    <option value="paleta_03" {{ $section->palette === 'paleta_03' ? 'selected' : '' }}>Paleta 03 (Dark Tech / SISCOOP3F)</option>
                </select>
            </div>
        </div>

        <div class="grid sm:grid-cols-3 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Título Principal</label>
                <input type="text" name="title" value="{{ old('title', $section->title) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-bold text-[#022B5B]">
            </div>
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Palavra/Frase em Destaque Colorido</label>
                <input type="text" name="highlighted_word" value="{{ old('highlighted_word', $section->highlighted_word) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-bold text-[#00B4D8]">
            </div>
        </div>

        <div>
            <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Subtítulo / Parágrafo Principal</label>
            <textarea name="subtitle" rows="2" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm">{{ old('subtitle', $section->subtitle) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Descrição Complementar</label>
            <textarea name="description" rows="2" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm">{{ old('description', $section->description) }}</textarea>
        </div>

        <div class="grid sm:grid-cols-5 gap-4">
            <div class="sm:col-span-2">
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Texto do Botão Principal</label>
                <input type="text" name="primary_cta_text" value="{{ old('primary_cta_text', $section->primary_cta_text) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Link do Botão Principal</label>
                <input type="text" name="primary_cta_url" value="{{ old('primary_cta_url', $section->primary_cta_url) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono">
            </div>
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Ordem</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $section->sort_order) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm">
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Texto do Botão Secundário</label>
                <input type="text" name="secondary_cta_text" value="{{ old('secondary_cta_text', $section->secondary_cta_text) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm">
            </div>
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-700 mb-1.5">Link do Botão Secundário</label>
                <input type="text" name="secondary_cta_url" value="{{ old('secondary_cta_url', $section->secondary_cta_url) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-mono">
            </div>
        </div>

        @if($section->section_key === 'hero')
            @php $extra = $section->extra_data ?? []; @endphp
            <div class="p-4 rounded-2xl bg-sky-50/70 border border-sky-200 space-y-3">
                <h3 class="font-brand text-xs font-bold uppercase tracking-wider text-[#00509D]">Métricas de Destaque do Hero</h3>
                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <input type="text" name="stat_1_value" value="{{ $extra['stat_1_value'] ?? '5 Verticais' }}" placeholder="Valor 1" class="w-full px-3 py-2 rounded-lg bg-white border border-slate-200 text-xs font-bold mb-1">
                        <input type="text" name="stat_1_label" value="{{ $extra['stat_1_label'] ?? 'Integradas em Rede Única' }}" placeholder="Legenda 1" class="w-full px-3 py-2 rounded-lg bg-white border border-slate-200 text-xs">
                    </div>
                    <div>
                        <input type="text" name="stat_2_value" value="{{ $extra['stat_2_value'] ?? '30 Dias' }}" placeholder="Valor 2" class="w-full px-3 py-2 rounded-lg bg-white border border-slate-200 text-xs font-bold mb-1">
                        <input type="text" name="stat_2_label" value="{{ $extra['stat_2_label'] ?? 'Implantação & Testes Sem Custo' }}" placeholder="Legenda 2" class="w-full px-3 py-2 rounded-lg bg-white border border-slate-200 text-xs">
                    </div>
                    <div>
                        <input type="text" name="stat_3_value" value="{{ $extra['stat_3_value'] ?? 'R$ 0,00' }}" placeholder="Valor 3" class="w-full px-3 py-2 rounded-lg bg-white border border-slate-200 text-xs font-bold mb-1">
                        <input type="text" name="stat_3_label" value="{{ $extra['stat_3_label'] ?? 'Desembolso Inicial da Receita' }}" placeholder="Legenda 3" class="w-full px-3 py-2 rounded-lg bg-white border border-slate-200 text-xs">
                    </div>
                </div>
            </div>
        @endif

        <div class="flex justify-end pt-2">
            <button type="submit" class="px-7 py-3.5 rounded-2xl font-brand font-bold text-xs uppercase tracking-wider text-white bg-gradient-to-r from-[#022B5B] to-[#00B4D8] shadow-md hover:opacity-95 transition">
                Salvar Textos da Seção
            </button>
        </div>
    </form>

    <!-- Gestão dos Cards / Itens Internos da Seção -->
    <div class="space-y-4 pt-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-brand text-lg font-extrabold text-[#022B5B]">Cards, Pilares e Benefícios Desta Seção ({{ $section->items->count() }})</h2>
                <p class="text-xs text-slate-500">Edite ou remova os cards existentes ou adicione um novo card abaixo.</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-5">
            @foreach($section->items as $item)
                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                    <form action="{{ route('admin.sections.items.update', $item) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                            <span class="text-xs font-brand font-bold text-[#0077B6]">Card #{{ $loop->iteration }}</span>
                            <label class="inline-flex items-center gap-1.5 text-xs font-semibold">
                                <input type="checkbox" name="is_active" value="1" {{ $item->is_active ? 'checked' : '' }} class="accent-[#00B4D8]">
                                <span>Ativo</span>
                            </label>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Badge Superior</label>
                                <input type="text" name="badge" value="{{ $item->badge }}" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                            </div>
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Métrica / Valor Destaque</label>
                                <input type="text" name="highlight_metric" value="{{ $item->highlight_metric }}" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-[#0077B6]">
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Título do Card *</label>
                                <input type="text" name="title" value="{{ $item->title }}" required class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-[#022B5B]">
                            </div>
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Subtítulo</label>
                                <input type="text" name="subtitle" value="{{ $item->subtitle }}" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Descrição</label>
                            <textarea name="description" rows="3" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">{{ $item->description }}</textarea>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Ícone</label>
                                <select name="icon" class="w-full px-2.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                    @foreach(['shield-check','cpu','bolt','network','video','heart-pulse','chart-bar','book-open','device-mobile','trending-up','users','clock','document-check','briefcase','academic-cap','sparkles'] as $ic)
                                        <option value="{{ $ic }}" {{ $item->icon === $ic ? 'selected' : '' }}>{{ $ic }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Cor de Acento</label>
                                <select name="accent_color" class="w-full px-2.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                    @foreach(['cyan','royal','turquoise','electric'] as $col)
                                        <option value="{{ $col }}" {{ $item->accent_color === $col ? 'selected' : '' }}>{{ ucfirst($col) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Ordem</label>
                                <input type="number" name="sort_order" value="{{ $item->sort_order }}" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Texto do Link (Opcional)</label>
                                <input type="text" name="link_text" value="{{ $item->link_text }}" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                            </div>
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">URL do Link (Opcional)</label>
                                <input type="text" name="link_url" value="{{ $item->link_url }}" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs font-mono">
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2">
                            <button type="submit" class="px-4 py-2 rounded-xl bg-[#022B5B] hover:bg-[#00509D] text-white text-xs font-brand font-bold transition">
                                Salvar Card
                            </button>
                        </div>
                    </form>

                    <form action="{{ route('admin.sections.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Deseja remover este card?')" class="border-t border-slate-100 pt-2 flex justify-end">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-rose-600 hover:underline font-semibold">Excluir Card</button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Adicionar Novo Card na Seção -->
        <form action="{{ route('admin.sections.items.store', $section) }}" method="POST" class="bg-slate-800 text-white rounded-3xl p-6 sm:p-8 space-y-4">
            @csrf
            <h3 class="font-brand text-base font-extrabold text-[#00E5FF]">+ Adicionar Novo Card / Item nesta Seção</h3>
            <div class="grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Badge Superior</label>
                    <input type="text" name="badge" placeholder="Ex: NOVO DIFERENCIAL" class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-sm text-white">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Título do Card *</label>
                    <input type="text" name="title" required placeholder="Título do diferencial" class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-sm text-white">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Subtítulo</label>
                    <input type="text" name="subtitle" placeholder="Subtítulo opcional" class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-sm text-white">
                </div>
            </div>

            <div class="grid sm:grid-cols-4 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Descrição</label>
                    <input type="text" name="description" placeholder="Texto explicativo do card..." class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-sm text-white">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Métrica Destaque</label>
                    <input type="text" name="highlight_metric" placeholder="Ex: 100% Digital" class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-sm text-white">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Ícone</label>
                    <select name="icon" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-700 border border-white/15 text-sm text-white">
                        @foreach(['sparkles','shield-check','cpu','bolt','network','video','heart-pulse','chart-bar','book-open','device-mobile','trending-up','users','clock','document-check','briefcase','academic-cap'] as $ic)
                            <option value="{{ $ic }}">{{ $ic }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <input type="hidden" name="accent_color" value="cyan">
            <input type="hidden" name="sort_order" value="{{ $section->items->count() + 1 }}">

            <button type="submit" class="px-6 py-3 rounded-xl font-brand font-bold text-xs uppercase tracking-wider text-[#022B5B] bg-[#00E5FF] hover:bg-[#80FFDB] transition">
                Adicionar Card à Seção
            </button>
        </form>
    </div>
@endsection
