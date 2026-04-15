<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-800 leading-tight">
            Minha Agenda de Trabalhos
        </h2>
    </x-slot>

    <div>
        <div class="mb-6">
            <h3 class="text-sm font-semibold text-gray-900">Próximos Eventos Confirmados</h3>
            <p class="text-sm text-gray-400 mt-0.5">Vagas em que você foi aprovado pelos restaurantes.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($trabalhos as $trabalho)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    <div class="h-1 bg-green-500"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-700 ring-1 ring-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                Confirmado
                            </span>
                            <span class="text-base font-bold text-gray-900">
                                R$ {{ number_format($trabalho->valor_diaria, 2, ',', '.') }}
                            </span>
                        </div>

                        <h4 class="text-base font-semibold text-gray-800 mb-3 leading-snug">{{ $trabalho->titulo_vaga }}</h4>

                        <div class="space-y-1.5 text-sm text-gray-500">
                            <p class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                <span>{{ $trabalho->restaurante }}</span>
                            </p>
                            <p class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                <span>{{ date('d/m/Y \à\s H:i', strtotime($trabalho->data_hora_inicio)) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl border border-gray-200 shadow-sm p-12 text-center">
                    <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-7 w-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 mb-1">Nenhum trabalho agendado</h3>
                    <p class="text-sm text-gray-400 mb-6">Você ainda não foi aprovado em nenhuma vaga. Continue se candidatando!</p>
                    <a href="{{ route('vagas.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition-colors">
                        Procurar Vagas
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
