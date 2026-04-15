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
                    <!-- Green top accent -->
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
                                <span>📍</span>
                                <span>{{ $trabalho->restaurante }}</span>
                            </p>
                            <p class="flex items-center gap-2">
                                <span>📅</span>
                                <span>{{ date('d/m/Y \à\s H:i', strtotime($trabalho->data_hora_inicio)) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl border border-gray-200 shadow-sm p-12 text-center">
                    <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-7 w-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
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
