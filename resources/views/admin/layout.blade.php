<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel CMS') — IntegreService Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('/assets/images/logo-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F1F5F9; }
        h1, h2, h3, h4, .font-brand { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex">
        <!-- Sidebar Escura Institucional -->
        <aside class="w-72 bg-[#021B3A] text-white flex flex-col justify-between shrink-0 hidden lg:flex border-r border-cyan-500/20">
            <div>
                <div class="p-6 border-b border-white/10">
                    <x-brand-logo theme="dark" size="sm" :href="route('admin.dashboard')" />
                    <span class="mt-3 inline-block px-2.5 py-0.5 rounded-md text-[10px] font-brand font-bold uppercase tracking-widest bg-cyan-500/20 text-cyan-300 border border-cyan-400/30">
                        CMS & Backoffice Executivo
                    </span>
                </div>

                <nav class="p-4 space-y-1.5 text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-brand font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-[#00509D] to-[#00B4D8] text-white shadow-md' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <x-icon name="chart-bar" class="w-5 h-5" />
                        <span>Visão Geral (Dashboard)</span>
                    </a>

                    <div class="pt-3 pb-1 px-4 text-[10px] font-brand font-bold uppercase tracking-widest text-cyan-400/80">
                        Conteúdo do Portal
                    </div>

                    <a href="{{ route('admin.sections.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-brand font-semibold transition {{ request()->routeIs('admin.sections.*') ? 'bg-gradient-to-r from-[#00509D] to-[#00B4D8] text-white shadow-md' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <x-icon name="cpu" class="w-5 h-5" />
                        <span>Seções & Cards do Site</span>
                    </a>

                    <a href="{{ route('admin.departments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-brand font-semibold transition {{ request()->routeIs('admin.departments.*') ? 'bg-gradient-to-r from-[#00509D] to-[#00B4D8] text-white shadow-md' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <x-icon name="heart-pulse" class="w-5 h-5" />
                        <span>Clínica & Departamentos</span>
                    </a>

                    <a href="{{ route('admin.publications.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-brand font-semibold transition {{ request()->routeIs('admin.publications.*') ? 'bg-gradient-to-r from-[#00509D] to-[#00B4D8] text-white shadow-md' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <x-icon name="book-open" class="w-5 h-5" />
                        <span>Livro & Publicações</span>
                    </a>

                    <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-brand font-semibold transition {{ request()->routeIs('admin.settings*') ? 'bg-gradient-to-r from-[#00509D] to-[#00B4D8] text-white shadow-md' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <x-icon name="shield-check" class="w-5 h-5" />
                        <span>Configurações, Links & Simulador</span>
                    </a>

                    <div class="pt-3 pb-1 px-4 text-[10px] font-brand font-bold uppercase tracking-widest text-cyan-400/80">
                        Comercial & Parcerias
                    </div>

                    <a href="{{ route('admin.leads.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl font-brand font-semibold transition {{ request()->routeIs('admin.leads.*') ? 'bg-gradient-to-r from-[#00509D] to-[#00B4D8] text-white shadow-md' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                        <span class="flex items-center gap-3">
                            <x-icon name="users" class="w-5 h-5" />
                            <span>Propostas & Leads (CRM)</span>
                        </span>
                        @php $newCount = \App\Models\Lead::where('status', 'novo')->count(); @endphp
                        @if($newCount > 0)
                            <span class="px-2 py-0.5 text-xs rounded-full bg-[#00E5FF] text-[#022B5B] font-extrabold">{{ $newCount }}</span>
                        @endif
                    </a>
                </nav>
            </div>

            <div class="p-4 border-t border-white/10 space-y-2">
                <a href="{{ route('portal.home') }}" target="_blank" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl bg-white/10 hover:bg-white/15 text-xs font-brand font-bold text-[#00E5FF] transition">
                    <span>Ver Portal Público Ao Vivo</span>
                    <span>↗</span>
                </a>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-2 px-4 rounded-xl text-xs font-brand font-semibold text-slate-400 hover:text-white hover:bg-white/5 transition">
                        Encerrar Sessão ({{ auth()->user()->name ?? 'Admin' }})
                    </button>
                </form>
            </div>
        </aside>

        <!-- Conteúdo Principal -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Topbar -->
            <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <div>
                        <h1 class="font-brand text-xl font-extrabold text-[#022B5B]">@yield('header', 'Painel de Controle')</h1>
                        <p class="text-xs text-slate-500">@yield('subheader', 'Gerencie todo o conteúdo do Portal IntegreService em tempo real.')</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('portal.home') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#022B5B] text-white text-xs font-brand font-bold hover:bg-[#00509D] transition">
                        <span>Visualizar Portal</span>
                        <span>↗</span>
                    </a>
                </div>
            </header>

            <!-- Navegação Rápida Mobile -->
            <div class="lg:hidden bg-[#021B3A] text-white px-4 py-2.5 flex items-center gap-2 overflow-x-auto text-xs font-brand font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 rounded-lg bg-white/10 shrink-0">Dashboard</a>
                <a href="{{ route('admin.sections.index') }}" class="px-3 py-1.5 rounded-lg bg-white/10 shrink-0">Seções & Cards</a>
                <a href="{{ route('admin.departments.index') }}" class="px-3 py-1.5 rounded-lg bg-white/10 shrink-0">Clínica</a>
                <a href="{{ route('admin.publications.index') }}" class="px-3 py-1.5 rounded-lg bg-white/10 shrink-0">Livro</a>
                <a href="{{ route('admin.settings') }}" class="px-3 py-1.5 rounded-lg bg-white/10 shrink-0">Configurações</a>
                <a href="{{ route('admin.leads.index') }}" class="px-3 py-1.5 rounded-lg bg-white/10 shrink-0">Propostas</a>
            </div>

            <main class="p-6 sm:p-8 max-w-7xl w-full mx-auto space-y-6">
                @if(session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-sm">
                        <strong class="font-brand font-bold block mb-1">Verifique os campos abaixo:</strong>
                        <ul class="list-disc list-inside space-y-0.5 text-xs">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
