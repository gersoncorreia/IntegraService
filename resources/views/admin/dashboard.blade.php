@extends('admin.layout')

@section('title', 'Dashboard Executivo')
@section('header', 'Central de Controle do Portal (CMS)')
@section('subheader', 'Gerencie todas as seções, cards, departamentos, publicações, links e solicitações de proposta.')

@section('content')
    <!-- Métricas de Resumo -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <a href="{{ route('admin.sections.index') }}" class="p-6 rounded-2xl bg-white border border-slate-200 hover:border-[#00B4D8] shadow-sm transition group">
            <span class="text-xs font-brand font-bold uppercase tracking-wider text-slate-400">Seções do Portal</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="font-brand text-3xl font-extrabold text-[#022B5B]">{{ $activeSectionsCount }}/{{ $sectionsCount }}</span>
                <span class="text-xs font-semibold text-[#0077B6] group-hover:translate-x-1 transition-transform">{{ $itemsCount }} cards ativos →</span>
            </div>
        </a>

        <a href="{{ route('admin.departments.index') }}" class="p-6 rounded-2xl bg-white border border-slate-200 hover:border-[#00B4D8] shadow-sm transition group">
            <span class="text-xs font-brand font-bold uppercase tracking-wider text-slate-400">Clínica & Departamentos</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="font-brand text-3xl font-extrabold text-[#022B5B]">{{ $departmentsCount }}</span>
                <span class="text-xs font-semibold text-[#0077B6] group-hover:translate-x-1 transition-transform">Gerenciar →</span>
            </div>
        </a>

        <a href="{{ route('admin.publications.index') }}" class="p-6 rounded-2xl bg-white border border-slate-200 hover:border-[#00B4D8] shadow-sm transition group">
            <span class="text-xs font-brand font-bold uppercase tracking-wider text-slate-400">Livro & Publicações</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="font-brand text-3xl font-extrabold text-[#022B5B]">{{ $publicationsCount }}</span>
                <span class="text-xs font-semibold text-[#0077B6] group-hover:translate-x-1 transition-transform">Editar obras →</span>
            </div>
        </a>

        <a href="{{ route('admin.leads.index') }}" class="p-6 rounded-2xl bg-gradient-to-br from-[#022B5B] to-[#00509D] text-white shadow-md transition group">
            <span class="text-xs font-brand font-bold uppercase tracking-wider text-cyan-300">Propostas & Leads (CRM)</span>
            <div class="flex items-baseline justify-between mt-2">
                <span class="font-brand text-3xl font-extrabold text-white">{{ $leadsCount }}</span>
                <span class="text-xs font-semibold text-[#80FFDB] group-hover:translate-x-1 transition-transform">{{ $newLeadsCount }} novos →</span>
            </div>
        </a>
    </div>

    <!-- Atalhos de Edição Rápida por Seção -->
    <div class="grid lg:grid-cols-12 gap-6">
        <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-brand text-lg font-extrabold text-[#022B5B]">Editar Seções do Portal</h2>
                    <p class="text-xs text-slate-500">Clique em qualquer seção abaixo para editar títulos, textos, botões e cards internos.</p>
                </div>
                <a href="{{ route('admin.sections.index') }}" class="text-xs font-brand font-bold text-[#0077B6] hover:underline">Ver todas →</a>
            </div>

            <div class="divide-y divide-slate-100">
                @foreach($sections as $sec)
                    <div class="py-3.5 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-2.5 rounded-full {{ $sec->is_active ? 'bg-emerald-500' : 'bg-slate-300' }}"></span>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-brand font-bold text-sm text-[#022B5B]">{{ $sec->nav_label ?: $sec->section_key }}</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded bg-slate-100 text-slate-600 font-mono">{{ $sec->palette }}</span>
                                    <span class="text-[10px] px-2 py-0.5 rounded bg-sky-50 text-[#0077B6] font-semibold">{{ $sec->items_count }} cards</span>
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-1">{{ $sec->title }} {{ $sec->highlighted_word }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.sections.edit', $sec) }}" class="px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-[#022B5B] hover:text-white text-xs font-brand font-bold text-[#022B5B] transition shrink-0">
                            Editar Conteúdo
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Últimas Solicitações de Proposta -->
        <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="font-brand text-lg font-extrabold text-[#022B5B]">Últimas Propostas (CRM)</h2>
                        <p class="text-xs text-slate-500">Contatos recebidos pelo formulário do portal.</p>
                    </div>
                    <a href="{{ route('admin.leads.index') }}" class="text-xs font-brand font-bold text-[#0077B6] hover:underline">Abrir CRM →</a>
                </div>

                <div class="space-y-3">
                    @forelse($recentLeads as $lead)
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                            <div class="flex items-center justify-between gap-2">
                                <strong class="font-brand text-sm text-[#022B5B]">{{ $lead->name }}</strong>
                                <span class="text-[10px] font-brand font-bold uppercase px-2.5 py-0.5 rounded-full bg-[#022B5B]/10 text-[#022B5B]">
                                    {{ $lead->statusLabel() }}
                                </span>
                            </div>
                            <p class="text-xs text-[#0077B6] font-semibold mt-0.5">{{ $lead->organization ?: 'Pessoa Física / Empresa' }} • {{ $lead->vertical_interest }}</p>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $lead->message }}</p>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 py-8 text-center">Nenhuma solicitação registrada ainda.</p>
                    @endforelse
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.settings') }}" class="flex items-center justify-between p-4 rounded-2xl bg-[#022B5B] text-white hover:bg-[#00509D] transition">
                    <div>
                        <span class="text-[10px] font-brand font-bold uppercase tracking-wider text-cyan-300 block">Configuração Rápida</span>
                        <strong class="font-brand text-sm">Editar WhatsApp, Links e Simulador SISCOOP3F</strong>
                    </div>
                    <span>→</span>
                </a>
            </div>
        </div>
    </div>
@endsection
