<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel de Controle') }} - {{ ucfirst(Auth::user()->tipo) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold mb-4">Bem-vindo, {{ Auth::user()->name }}!</h3>

                @if(Auth::user()->tipo == 'restaurante')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-indigo-50 border border-indigo-200 rounded-lg">
                            <h4 class="font-bold">Gerenciar Vagas</h4>
                            <p class="text-sm mb-3">Publique novas oportunidades para freelancers.</p>
                            <a href="{{ route('vagas.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                                + Cadastrar Nova Vaga
                            </a>
                        </div>
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <h4 class="font-bold">Minhas Vagas</h4>
                            <p class="text-sm mb-3">Veja quem se candidatou aos seus turnos.</p>
                            <a href="{{ route('vagas.index') }}" class="text-indigo-600 font-semibold underline">Ver todas as vagas</a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                            <h4 class="font-bold">Ache um Trampo</h4>
                            <p class="text-sm mb-3">Procure turnos disponíveis em restaurantes da região.</p>
                            <a href="{{ route('vagas.index') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                Buscar Vagas
                            </a>
                        </div>
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <h4 class="font-bold">Minhas Escalas</h4>
                            <p class="text-sm mb-3">Veja para onde você já está escalado.</p>
                            <a href="{{ route('agenda.index') }}" class="text-green-600 font-semibold underline">Ver minha agenda</a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>