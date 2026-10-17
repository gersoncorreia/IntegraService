@extends('admin.layout')

@section('title', 'Seções & Cards do Portal')
@section('header', 'Gerenciar Seções & Cards do Portal')
@section('subheader', 'Selecione qualquer seção abaixo para editar seus títulos, subtítulos, botões, paleta de cores e seus cards internos.')

@section('content')
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($sections as $section)
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-brand font-bold uppercase tracking-wider {{ $section->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                            {{ $section->is_active ? 'Visível no Site' : 'Oculta' }}
                        </span>
                        <span class="text-xs font-mono text-slate-400">#{{ $section->section_key }}</span>
                    </div>

                    <h3 class="font-brand text-xl font-extrabold text-[#022B5B]">
                        {{ $section->nav_label ?: ucfirst($section->section_key) }}
                    </h3>
                    <p class="text-xs font-semibold text-[#0077B6] mt-1 line-clamp-1">
                        {{ $section->badge_text }}
                    </p>
                    <p class="text-sm text-slate-600 mt-2 line-clamp-2">
                        {{ $section->title }} <strong class="text-[#00B4D8]">{{ $section->highlighted_word }}</strong>
                    </p>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs font-brand font-bold text-slate-500">
                        {{ $section->items->count() }} cards vinculados
                    </span>
                    <a href="{{ route('admin.sections.edit', $section) }}" class="px-4 py-2 rounded-xl bg-[#022B5B] hover:bg-[#00509D] text-white text-xs font-brand font-bold transition">
                        Editar Seção & Cards →
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
