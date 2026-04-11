<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minha Agenda de Trabalhos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900">Seus Próximos Eventos Confirmados</h3>
                <p class="text-sm text-gray-500">Aqui estão as vagas em que você foi aprovado pelos restaurantes.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($trabalhos as $trabalho)
                    <div class="bg-white overflow-hidden shadow-sm rounded-lg border-l-4 border-green-500 hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-bold bg-green-100 text-green-800 px-2 py-1 rounded uppercase">
                                    Confirmado
                                </span>
                                <span class="text-lg font-bold text-gray-900">
                                    R$ {{ number_format($trabalho->valor_diaria, 2, ',', '.') }}
                                </span>
                            </div>

                            <h4 class="text-xl font-semibold text-gray-800 mb-2">{{ $trabalho->titulo_vaga }}</h4>
                            
                            <div class="space-y-2 mb-4 text-sm text-gray-600">
                                <p class="flex items-center">
                                    <span class="font-bold mr-2">📍 Local:</span> 
                                    {{ $trabalho->restaurante }}
                                </p>
                                <p class="flex items-center">
                                    <span class="font-bold mr-2">📅 Data:</span> 
                                    {{ date('d/m/Y \à\s H:i', strtotime($trabalho->data_hora_inicio)) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-10 text-center rounded-lg shadow-sm border border-gray-200">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900">Nenhum trabalho agendado</h3>
                        <p class="mt-1 text-gray-500">Você ainda não foi aprovado em nenhuma vaga. Continue se candidatando!</p>
                        <div class="mt-6">
                            <a href="{{ route('vagas.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                                Procurar Vagas
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>