<x-app-layout>
    <x-slot name="header">
        <h2 class="text-base font-semibold text-slate-700 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="max-w-5xl space-y-6">

        <!-- Saudação mobile-friendly -->
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xl font-bold text-slate-900">
                    Olá, {{ explode(' ', Auth::user()->name)[0] }} 👋
                </p>
                <p class="text-sm text-slate-500 mt-0.5">{{ ucfirst(Auth::user()->tipo) }} &mdash; bem-vindo de volta</p>
            </div>
            @if(Auth::user()->foto_perfil)
                <img src="{{ Storage::url(Auth::user()->foto_perfil) }}"
                     alt="{{ Auth::user()->name }}"
                     class="w-12 h-12 rounded-2xl object-cover ring-2 ring-slate-100 lg:hidden">
            @else
                <div class="w-12 h-12 rounded-2xl bg-orange-500 flex items-center justify-center lg:hidden">
                    <span class="text-lg font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
            @endif
        </div>

        @if(Auth::user()->tipo == 'restaurante')

            <!-- Banner hero desktop -->
            <div class="hidden lg:flex rounded-2xl bg-gradient-to-r from-slate-900 to-slate-800 px-8 py-8 items-center gap-6">
                <div class="w-16 h-16 rounded-2xl bg-orange-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-orange-500/30">
                    <span class="text-2xl font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-slate-400">Bem-vindo de volta,</p>
                    <p class="text-2xl font-bold text-white mt-0.5">{{ Auth::user()->name }}</p>
                    <p class="text-sm text-slate-400 mt-1">Gerencie suas vagas e encontre os melhores garçons.</p>
                </div>
                <a href="{{ route('vagas.create') }}"
                   class="flex-shrink-0 inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl px-5 py-2.5 transition-all shadow-sm hover:shadow-md active:scale-95">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Nova Vaga
                </a>
            </div>

            <!-- Stats restaurante — grid 2x2 mobile, 4 em linha desktop -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900">{{ $stats['total_vagas'] ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Total de Vagas</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-emerald-600">{{ $stats['vagas_abertas'] ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Vagas Abertas</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-amber-500">{{ $stats['candidaturas_pendentes'] ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Pendentes</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-9 h-9 rounded-xl bg-orange-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-orange-500">{{ $stats['contratados'] ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-1 font-medium">Contratados</p>
                </div>
            </div>

            <!-- Ações restaurante -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 hover:shadow-md transition-shadow">
                    <div class="w-11 h-11 rounded-xl bg-orange-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-slate-900 mb-1">Publicar Nova Vaga</h4>
                    <p class="text-sm text-slate-500 mb-5">Crie uma oportunidade e encontre o garçom ideal.</p>
                    <a href="{{ route('vagas.create') }}"
                       class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl px-5 py-2.5 transition-all shadow-sm hover:shadow-md active:scale-95 text-sm">
                        Cadastrar Nova Vaga
                    </a>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 hover:shadow-md transition-shadow">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-slate-900 mb-1">Minhas Vagas</h4>
                    <p class="text-sm text-slate-500 mb-5">Veja quem se candidatou aos seus turnos.</p>
                    <a href="{{ route('vagas.index') }}"
                       class="inline-flex items-center gap-1 text-sm font-semibold text-orange-600 hover:text-orange-700 transition-colors">
                        Ver todas as vagas
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>
            </div>

        @else

            <!-- Banner hero desktop (garçom) -->
            <div class="hidden lg:flex rounded-2xl bg-gradient-to-r from-slate-900 to-slate-800 px-8 py-8 items-center gap-6">
                <div class="w-16 h-16 rounded-2xl bg-orange-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-orange-500/30">
                    <span class="text-2xl font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm text-slate-400">Pronto para trabalhar?</p>
                    <p class="text-2xl font-bold text-white mt-0.5">{{ Auth::user()->name }}</p>
                    <p class="text-sm text-slate-400 mt-1">Encontre turnos disponíveis em restaurantes da região.</p>
                </div>
                <a href="{{ route('vagas.index') }}"
                   class="flex-shrink-0 inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl px-5 py-2.5 transition-all shadow-sm hover:shadow-md active:scale-95">
                    Buscar Vagas
                </a>
            </div>

            <!-- Stats garçom — grid 3 colunas -->
            <div class="grid grid-cols-3 gap-3 lg:gap-4">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 lg:p-5 text-center">
                    <p class="text-2xl lg:text-3xl font-bold text-slate-900">{{ $stats['candidaturas_enviadas'] ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-1 font-medium leading-tight">Candidaturas</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 lg:p-5 text-center">
                    <p class="text-2xl lg:text-3xl font-bold text-amber-500">{{ $stats['pendentes'] ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-1 font-medium leading-tight">Em Análise</p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 lg:p-5 text-center">
                    <p class="text-2xl lg:text-3xl font-bold text-emerald-600">{{ $stats['trabalhos_confirmados'] ?? 0 }}</p>
                    <p class="text-xs text-slate-500 mt-1 font-medium leading-tight">Confirmados</p>
                </div>
            </div>

            <!-- Próximo trabalho -->
            @if(!empty($stats['proximo_trabalho']))
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 flex items-center gap-4">
                    <div class="w-11 h-11 rounded-xl bg-emerald-500 flex items-center justify-center flex-shrink-0 shadow-sm">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-emerald-700 uppercase tracking-wider">Proximo trabalho</p>
                        <p class="font-semibold text-emerald-900">{{ $stats['proximo_trabalho']->titulo_vaga }}</p>
                        <p class="text-sm text-emerald-700">{{ date('d/m/Y \à\s H:i', strtotime($stats['proximo_trabalho']->data_hora_inicio)) }}</p>
                    </div>
                </div>
            @endif

            <!-- Ações garçom -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 hover:shadow-md transition-shadow">
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-slate-900 mb-1">Ache um Trampo</h4>
                    <p class="text-sm text-slate-500 mb-5">Procure turnos disponíveis em restaurantes da região.</p>
                    <a href="{{ route('vagas.index') }}"
                       class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl px-5 py-2.5 transition-all shadow-sm hover:shadow-md active:scale-95 text-sm min-h-[44px]">
                        Buscar Vagas
                    </a>
                </div>

                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 hover:shadow-md transition-shadow">
                    <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-slate-900 mb-1">Minhas Escalas</h4>
                    <p class="text-sm text-slate-500 mb-5">Veja para onde você já está escalado.</p>
                    <a href="{{ route('agenda.index') }}"
                       class="inline-flex items-center gap-1 text-sm font-semibold text-orange-600 hover:text-orange-700 transition-colors">
                        Ver minha agenda
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </div>
            </div>

        @endif
    </div>
</x-app-layout>
