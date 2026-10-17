@extends('admin.layout')

@section('title', 'Clínica & Departamentos')
@section('header', 'Gerenciar Departamentos da Clínica')
@section('subheader', 'Cadastre, edite ou reordene os departamentos médicos e suas taglines de sub-marca conforme o Manual de Identidade.')

@section('content')
    <div class="grid lg:grid-cols-2 gap-6">
        @foreach($departments as $dept)
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                <form action="{{ route('admin.departments.update', $dept) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <span class="text-xs font-brand font-bold text-[#0077B6]">Departamento #{{ $loop->iteration }}</span>
                        <label class="inline-flex items-center gap-1.5 text-xs font-semibold">
                            <input type="checkbox" name="is_active" value="1" {{ $dept->is_active ? 'checked' : '' }} class="accent-[#00B4D8]">
                            <span>Ativo no Portal</span>
                        </label>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Nome do Departamento *</label>
                            <input type="text" name="name" value="{{ $dept->name }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-[#022B5B]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Tagline na Logo (Sub-marca) *</label>
                            <input type="text" name="custom_tagline" value="{{ $dept->custom_tagline }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold text-[#0077B6]">
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Badge Superior</label>
                            <input type="text" name="badge" value="{{ $dept->badge }}" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                        </div>
                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Ícone</label>
                            <select name="icon" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                                @foreach(['heart-pulse','sparkles','shield-check','network','video','users','clock'] as $ic)
                                    <option value="{{ $ic }}" {{ $dept->icon === $ic ? 'selected' : '' }}>{{ $ic }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Ordem</label>
                            <input type="number" name="sort_order" value="{{ $dept->sort_order }}" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Resumo Principal *</label>
                        <textarea name="short_description" rows="2" required class="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">{{ $dept->short_description }}</textarea>
                    </div>

                    <div>
                        <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Descrição Detalhada</label>
                        <textarea name="full_description" rows="2" class="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">{{ $dept->full_description }}</textarea>
                    </div>

                    <div>
                        <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Lista de Diferenciais (1 por linha)</label>
                        <textarea name="features_text" rows="4" class="w-full px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">{{ is_array($dept->features) ? implode("\n", $dept->features) : '' }}</textarea>
                    </div>

                    <div class="flex items-center justify-between gap-3 pt-2">
                        <div class="flex-1">
                            <input type="text" name="cta_text" value="{{ $dept->cta_text }}" placeholder="Texto do Botão" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-200 text-xs">
                        </div>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#022B5B] hover:bg-[#00509D] text-white text-xs font-brand font-bold transition">
                            Salvar Alterações
                        </button>
                    </div>
                </form>

                <form action="{{ route('admin.departments.destroy', $dept) }}" method="POST" onsubmit="return confirm('Remover este departamento?')" class="border-t border-slate-100 pt-2 flex justify-end">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs text-rose-600 hover:underline font-semibold">Excluir Departamento</button>
                </form>
            </div>
        @endforeach
    </div>

    <!-- Cadastrar Novo Departamento -->
    <form action="{{ route('admin.departments.store') }}" method="POST" class="bg-[#021B3A] text-white rounded-3xl p-6 sm:p-8 space-y-4">
        @csrf
        <h3 class="font-brand text-lg font-extrabold text-[#00F5D4]">+ Cadastrar Novo Departamento da Clínica</h3>

        <div class="grid sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Nome do Departamento *</label>
                <input type="text" name="name" required placeholder="Ex: Cardiologia & Diagnóstico" class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-sm text-white">
            </div>
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Tagline da Sub-marca *</label>
                <input type="text" name="custom_tagline" required value="Clínica Médica & Especialidades" class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-sm text-white">
            </div>
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Badge Superior</label>
                <input type="text" name="badge" placeholder="Ex: UNIDADE ESPECIALIZADA" class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-sm text-white">
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Resumo Principal *</label>
                <textarea name="short_description" rows="2" required class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-sm text-white"></textarea>
            </div>
            <div>
                <label class="block text-xs font-brand font-bold uppercase text-slate-300 mb-1">Diferenciais (1 por linha)</label>
                <textarea name="features_text" rows="2" placeholder="Atendimento humanizado&#10;Integração com Telemedicina" class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/15 text-sm text-white"></textarea>
            </div>
        </div>

        <input type="hidden" name="icon" value="heart-pulse">
        <input type="hidden" name="cta_text" value="Agendar Atendimento">
        <input type="hidden" name="sort_order" value="{{ $departments->count() + 1 }}">

        <button type="submit" class="px-6 py-3 rounded-xl font-brand font-bold text-xs uppercase tracking-wider text-[#021B3A] bg-[#00F5D4] hover:bg-[#80FFDB] transition">
            Adicionar Departamento
        </button>
    </form>
@endsection
