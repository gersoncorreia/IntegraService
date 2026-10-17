@extends('admin.layout')

@section('title', 'CRM de Propostas & Leads')
@section('header', 'CRM de Solicitações de Proposta & Parcerias')
@section('subheader', 'Acompanhe todas as cooperativas, empresas e clientes que solicitaram contato pelo portal.')

@section('content')
    <!-- Filtros de Status -->
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('admin.leads.index') }}" class="px-4 py-2 rounded-xl text-xs font-brand font-bold {{ !request('status') ? 'bg-[#022B5B] text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
            Todos ({{ \App\Models\Lead::count() }})
        </a>
        @foreach(['novo' => 'Novos', 'em_analise' => 'Em Análise', 'proposta_enviada' => 'Proposta Enviada', 'fechado' => 'Parceria Fechada'] as $stKey => $stLabel)
            <a href="{{ route('admin.leads.index', ['status' => $stKey]) }}" class="px-4 py-2 rounded-xl text-xs font-brand font-bold {{ request('status') === $stKey ? 'bg-[#00509D] text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
                {{ $stLabel }} ({{ \App\Models\Lead::where('status', $stKey)->count() }})
            </a>
        @endforeach
    </div>

    <div class="space-y-4">
        @forelse($leads as $lead)
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <div class="grid lg:grid-cols-12 gap-6 items-start">
                    <div class="lg:col-span-7 space-y-2">
                        <div class="flex flex-wrap items-center gap-2.5">
                            <span class="px-3 py-1 rounded-full text-[11px] font-brand font-bold uppercase bg-[#022B5B] text-[#00E5FF]">
                                {{ $lead->vertical_interest }}
                            </span>
                            @if($lead->estimated_users)
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-[#0077B6]">
                                    ~{{ number_format($lead->estimated_users, 0, ',', '.') }} usuários
                                </span>
                            @endif
                            <span class="text-xs text-slate-400">
                                Recebido em {{ $lead->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>

                        <h3 class="font-brand text-xl font-extrabold text-[#022B5B]">
                            {{ $lead->name }}
                            @if($lead->organization)
                                <span class="text-[#0077B6]">— {{ $lead->organization }}</span>
                            @endif
                        </h3>

                        <p class="text-xs text-slate-500">
                            Cargo: <strong>{{ $lead->role ?: 'Não informado' }}</strong> •
                            E-mail: <strong>{{ $lead->email }}</strong> •
                            Tel/WhatsApp: <strong>{{ $lead->phone }}</strong>
                        </p>

                        @if($lead->message)
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 text-xs sm:text-sm text-slate-700 mt-2">
                                "{{ $lead->message }}"
                            </div>
                        @endif

                        <div class="pt-2 flex flex-wrap items-center gap-3">
                            <a
                                href="https://wa.me/55{{ preg_replace('/\D/', '', $lead->phone) }}?text={{ urlencode("Olá {$lead->name}, aqui é da IntegreService sobre sua solicitação referente a {$lead->vertical_interest}.") }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-brand font-bold transition"
                            >
                                <span>Chamar no WhatsApp</span>
                                <span>↗</span>
                            </a>
                            <a href="mailto:{{ $lead->email }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-brand font-bold transition">
                                Enviar E-mail
                            </a>
                        </div>
                    </div>

                    <!-- Atualização de Status e Notas Internas -->
                    <div class="lg:col-span-5 bg-slate-50 rounded-2xl p-4 border border-slate-200/80">
                        <form action="{{ route('admin.leads.update', $lead) }}" method="POST" class="space-y-3">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Status da Negociação</label>
                                <select name="status" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-[#022B5B]">
                                    <option value="novo" {{ $lead->status === 'novo' ? 'selected' : '' }}>Novo Contato</option>
                                    <option value="em_analise" {{ $lead->status === 'em_analise' ? 'selected' : '' }}>Em Análise / Diagnóstico</option>
                                    <option value="proposta_enviada" {{ $lead->status === 'proposta_enviada' ? 'selected' : '' }}>Carta de Intenção / Proposta Enviada</option>
                                    <option value="fechado" {{ $lead->status === 'fechado' ? 'selected' : '' }}>Parceria Fechada</option>
                                    <option value="arquivado" {{ $lead->status === 'arquivado' ? 'selected' : '' }}>Arquivado</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-brand font-bold uppercase text-slate-600 mb-1">Anotações Executivas Internas</label>
                                <textarea name="admin_notes" rows="2" placeholder="Registre histórico de reuniões, valores ou observações..." class="w-full px-3 py-2 rounded-xl bg-white border border-slate-200 text-xs">{{ $lead->admin_notes }}</textarea>
                            </div>

                            <div class="flex items-center justify-between">
                                <button type="submit" class="px-4 py-2 rounded-xl bg-[#022B5B] hover:bg-[#00509D] text-white text-xs font-brand font-bold transition">
                                    Salvar Acompanhamento
                                </button>
                            </div>
                        </form>

                        <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" onsubmit="return confirm('Remover este lead?')" class="mt-2 pt-2 border-t border-slate-200/70 flex justify-end">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[11px] text-rose-600 hover:underline font-semibold">Excluir Registro</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center text-slate-400">
                Nenhuma solicitação de proposta encontrada para este filtro.
            </div>
        @endforelse
    </div>
@endsection
