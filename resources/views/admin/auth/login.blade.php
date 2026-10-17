<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Administrativo — IntegreService CMS</title>
    <link rel="icon" type="image/png" href="{{ asset('/assets/images/logo-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-brand { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#011329] via-[#022B5B] to-[#004E89] flex items-center justify-center p-4 text-white">

    <div class="w-full max-w-md rounded-3xl bg-white/10 border border-cyan-400/30 backdrop-blur-xl p-8 shadow-2xl">
        <div class="flex flex-col items-center text-center pb-6 border-b border-white/15">
            <x-brand-logo theme="dark" size="md" :href="route('portal.home')" />
            <span class="mt-3 px-3 py-1 rounded-full text-[11px] font-brand font-bold uppercase tracking-widest bg-cyan-400/15 text-cyan-300 border border-cyan-400/30">
                Central de Gestão de Conteúdo (CMS)
            </span>
        </div>

        @if($errors->any())
            <div class="mt-5 p-3.5 rounded-xl bg-rose-500/20 border border-rose-400/40 text-xs text-rose-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="mt-6 space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-brand font-bold uppercase tracking-wider text-cyan-200 mb-2">E-mail do Administrador</label>
                <input type="email" name="email" value="{{ old('email', 'admin@integreservice.com.br') }}" required class="w-full px-4 py-3.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-[#00E5FF] focus:outline-none text-sm">
            </div>

            <div>
                <label class="block text-xs font-brand font-bold uppercase tracking-wider text-cyan-200 mb-2">Senha de Acesso</label>
                <input type="password" name="password" value="Integre@2026" required class="w-full px-4 py-3.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:border-[#00E5FF] focus:outline-none text-sm">
                <span class="text-[11px] text-cyan-300/80 mt-1 block">Padrão inicial: admin@integreservice.com.br / Integre@2026</span>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl font-brand font-bold text-xs uppercase tracking-wider text-[#022B5B] bg-gradient-to-r from-[#00E5FF] to-[#80FFDB] hover:shadow-[0_0_25px_rgba(0,229,255,0.5)] transition">
                Entrar no Painel Administrativo
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-white/10 text-center">
            <a href="{{ route('portal.home') }}" class="text-xs text-cyan-300 hover:text-white transition">
                ← Voltar para o Portal Público IntegreService
            </a>
        </div>
    </div>

</body>
</html>
