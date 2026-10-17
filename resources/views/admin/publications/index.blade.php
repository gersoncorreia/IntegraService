@extends('admin.layout')

@section('title', 'Livro & Publicações')
@section('header', 'Gerenciar Livro Oficial & Publicações')
@section('subheader', 'Edite os dados do Livro Oficial (exibido em 3D no portal) e cadastre novos estudos de caso, artigos ou cadernos técnicos.')

@section('content')
    <div class="space-y-6">
        @foreach($publications as $pub)
            <div class="bg-white rounded-3xl border {{ $pub->is_featured_book ? 'border-[#00B4D8] ring-2 ring-[#00B4D8]/15' : 'border-slate-200' }} p-6 sm:p-8 shadow-sm space-y-4">
                <form action="{{ route('admin.publications.update', $pub) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-2">
                            @if($pub->is_featured_book)
                                <span class="px-3 py-1 rounded-full text-xs font-brand font-bold bg-[#022B5B] text-[#00E5FF]">
                                    ★ Livro Oficial em Destaque 3D
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-brand font-bold bg-slate-100 text-slate-700">
                                    Publicação / Artigo
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center gap-4 text-xs font-semibold">
                            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" name="is_featured_book" value="1" {{ $pub->is_featured_book ? 'checked' : '' }} class="accent-[#022B5B]">
                                <span>Destacar como Livro Principal 3D</span>
                            </label>
                            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" {{ $pub->is_active ? 'checked' : '' }} class="accent-[#00B4D8]">
                                <span>Visível no Portal</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Título da Obra / Publicação *</label>
                            <input type="text" name="title" value="{{ $pub->title }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm font-bold text-[#022B5B]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Subtítulo</label>
                            <input type="text" name="subtitle" value="{{ $pub->subtitle }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Categoria *</label>
                            <input type="text" name="category" value="{{ $pub->category }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Autoria *</label>
                            <input type="text" name="author" value="{{ $pub->author }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Ano *</label>
                            <input type="text" name="year" value="{{ $pub->year }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Ordem</label>
                            <input type="number" name="sort_order" value="{{ $pub->sort_order }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Sinopse / Resumo *</label>
                            <textarea name="summary" rows="3" required class="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">{{ $pub->summary }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Conteúdo Complementar</label>
                            <textarea name="content" rows="3" class="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">{{ $pub->content }}</textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Tópicos de Destaque / Capítulos (1 por linha)</label>
                        <textarea name="highlights_text" rows="3" class="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">{{ is_array($pub->highlights) ? implode("\n", $pub->highlights) : '' }}</textarea>
                    </div>

                    <div class="flex items-center justify-between gap-4 pt-2">
                        <input type="text" name="cta_text" value="{{ $pub->cta_text }}" class="w-72 px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#022B5B] hover:bg-[#00509D] text-white text-xs font-brand font-bold transition">
                            Salvar Publicação
                        </button>
                    </div>
                </form>

                <form action="{{ route('admin.publications.destroy', $pub) }}" method="POST" onsubmit="return confirm('Remover esta publicação?')" class="border-t border-slate-100 pt-2 flex justify-end">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs text-rose-600 hover:underline font-semibold">Excluir Publicação</button>
                </form>
            </div>
        @endforeach

        <!-- Nova Publicação -->
        <form action="{{ route('admin.publications.store') }}" method="POST" class="bg-[#021B3A] text-white rounded-3xl p-6 sm:p-8 space-y-4">
            @csrf
            <h3 class="font-brand text-lg font-extrabold text-[#00E5FF]">+ Cadastrar Nova Publicação / Artigo ou Livro</h3>
            <div class="grid sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Título *</label>
                    <input type="text" name="title" required class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-sm text-white">
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Categoria *</label>
                    <input type="text" name="category" value="Artigo Técnico" required class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-sm text-white">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Resumo *</label>
                    <textarea name="summary" rows="2" required class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-sm text-white"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Destaques (1 por linha)</label>
                    <textarea name="highlights_text" rows="2" class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-sm text-white"></textarea>
                </div>
            </div>

            <input type="hidden" name="author" value="Eudemir Bezerra • IntegreService">
            <input type="hidden" name="year" value="{{ date('Y') }}">
            <input type="hidden" name="cta_text" value="Solicitar Material Completo">
            <input type="hidden" name="sort_order" value="{{ $publications->count() + 1 }}">

            <button type="submit" class="px-6 py-3 rounded-xl font-brand font-bold text-xs uppercase tracking-wider text-[#022B5B] bg-[#00E5FF] hover:bg-[#80FFDB] transition">
                Adicionar Publicação
            </button>
        </form>
    </div>
@endsection
