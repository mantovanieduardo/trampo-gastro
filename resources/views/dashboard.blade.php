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
                        <span class="text-xl">➕</span>
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
                        <span class="text-xl">📋</span>
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
                        <span class="text-xl">🍽️</span>
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
                        <span class="text-xl">📅</span>
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
