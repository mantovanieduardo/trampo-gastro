<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-800 leading-tight">
            Painel de Controle &mdash; <span class="text-gray-500 font-normal">{{ ucfirst(Auth::user()->tipo) }}</span>
        </h2>
    </x-slot>

    <div class="max-w-4xl">

        <!-- Welcome banner -->
        <div class="mb-6 rounded-xl bg-gray-900 px-8 py-6 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0">
                <span class="text-xl font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </div>
            <div>
                <p class="text-sm text-gray-400">Bem-vindo de volta,</p>
                <p class="text-lg font-bold text-white">{{ Auth::user()->name }}</p>
            </div>
        </div>

        <!-- Cards -->
        @if(Auth::user()->tipo == 'restaurante')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-1">Gerenciar Vagas</h4>
                    <p class="text-sm text-gray-500 mb-4">Publique novas oportunidades para freelancers.</p>
                    <a href="{{ route('vagas.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors">
                        + Cadastrar Nova Vaga
                    </a>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-1">Minhas Vagas</h4>
                    <p class="text-sm text-gray-500 mb-4">Veja quem se candidatou aos seus turnos.</p>
                    <a href="{{ route('vagas.index') }}"
                       class="inline-flex items-center text-sm font-semibold text-amber-600 hover:text-amber-700 transition-colors">
                        Ver todas as vagas &rarr;
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-1">Ache um Trampo</h4>
                    <p class="text-sm text-gray-500 mb-4">Procure turnos disponíveis em restaurantes da região.</p>
                    <a href="{{ route('vagas.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition-colors">
                        Buscar Vagas
                    </a>
                </div>

                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-1">Minhas Escalas</h4>
                    <p class="text-sm text-gray-500 mb-4">Veja para onde você já está escalado.</p>
                    <a href="{{ route('agenda.index') }}"
                       class="inline-flex items-center text-sm font-semibold text-green-600 hover:text-green-700 transition-colors">
                        Ver minha agenda &rarr;
                    </a>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
