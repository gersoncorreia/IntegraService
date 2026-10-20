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
</head>
<body class="min-h-screen section-dark-hero flex items-center justify-center p-4 text-white">

    <div class="w-full max-w-md rounded-lg bg-[#011328]/95 border border-white/15 shadow-[0_24px_60px_rgba(0,0,0,0.55)] overflow-hidden">
        <!-- Barra Superior Luminosa -->
        <div class="h-1 w-full bg-gradient-to-r from-[#00509D] via-[#00E5FF] to-[#80FFDB]"></div>

        <div class="p-7 sm:p-9">
            <div class="flex flex-col items-center text-center pb-6 border-b border-white/10">
                <x-brand-logo theme="dark" size="md" :href="route('portal.home')" />
                <span class="mt-3.5 px-3 py-1 rounded-xs text-[10px] font-brand font-bold uppercase tracking-[0.14em] bg-white/[0.06] text-[#00E5FF] border-l-2 border-[#00E5FF]">
                    Central de Gestão de Conteúdo (CMS)
                </span>
            </div>

            @if($errors->any())
                <div class="mt-5 p-3.5 rounded bg-rose-500/15 border border-rose-400/40 border-l-4 border-l-rose-500 text-xs text-rose-200">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="mt-6 space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-brand font-bold uppercase tracking-wider text-cyan-200 mb-2">
                        E-mail do Administrador
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="seu-email@dominio.com.br"
                        required
                        autofocus
                        class="w-full h-11 px-4 rounded bg-white/[0.06] border border-white/20 text-white placeholder-slate-400 focus:border-[#00E5FF] focus:bg-white/[0.1] focus:outline-none text-base sm:text-sm transition"
                    >
                </div>

                <div>
                    <label class="block text-xs font-brand font-bold uppercase tracking-wider text-cyan-200 mb-2">
                        Senha de Acesso
                    </label>
                    <div class="relative">
                        <input
                            id="admin-password-input"
                            type="password"
                            name="password"
                            placeholder="Digite sua senha"
                            required
                            class="w-full h-11 pl-4 pr-16 rounded bg-white/[0.06] border border-white/20 text-white placeholder-slate-400 focus:border-[#00E5FF] focus:bg-white/[0.1] focus:outline-none text-base sm:text-sm transition"
                        >
                        <button
                            type="button"
                            onclick="const p = document.getElementById('admin-password-input'); p.type = p.type === 'password' ? 'text' : 'password'; this.textContent = p.type === 'password' ? 'MOSTRAR' : 'OCULTAR';"
                            class="absolute right-2.5 top-1/2 -translate-y-1/2 px-2 py-1 rounded text-[10px] font-brand font-bold text-cyan-300 hover:bg-white/10 cursor-pointer"
                        >
                            MOSTRAR
                        </button>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full py-4 rounded font-brand font-bold text-xs uppercase tracking-[0.12em] text-[#01162E] bg-[#00E5FF] hover:bg-[#80FFDB] shadow-lg transition cursor-pointer"
                >
                    Entrar no Painel Administrativo →
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-white/10 text-center">
                <a href="{{ route('portal.home') }}" class="text-xs font-brand font-semibold text-cyan-300 hover:text-white transition">
                    ← Voltar para o Portal Público IntegreService
                </a>
            </div>
        </div>
    </div>

</body>
</html>
