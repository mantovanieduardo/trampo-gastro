<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800 leading-tight">Detalhes da Vaga</h2>
            <a href="{{ route('vagas.index') }}" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
                &larr; Voltar para vagas
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl space-y-4">

        @if(session('sucesso'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('sucesso') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Card principal -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="h-1.5 {{ $vaga->status_vaga == 'aberta' ? 'bg-green-500' : 'bg-gray-300' }}"></div>
            <div class="p-8">
                <div class="flex items-start justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $vaga->titulo_vaga }}</h1>
                        @if($restaurante)
                            <p class="text-sm text-gray-500">por <span class="font-medium text-gray-700">{{ $restaurante->nome_fantasia }}</span></p>
                        @endif
                    </div>
                    <div class="flex-shrink-0 text-right">
                        <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($vaga->valor_diaria, 2, ',', '.') }}</p>
                        @if($vaga->status_vaga == 'aberta')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-700 ring-1 ring-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aberta
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600 ring-1 ring-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Fechada
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Infos rápidas -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6 pb-6 border-b border-gray-100">
                    @if($vaga->data_hora_inicio)
                        <div>
                            <p class="text-xs text-gray-400 font-medium mb-0.5">Data e Hora</p>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ $vaga->data_hora_inicio->format('d/m/Y \à\s H:i') }}
                            </p>
                        </div>
                    @endif
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Tipo de Contrato</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $vaga->tipo_contrato }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Candidatos</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $totalCandidatos }} inscrito(s)</p>
                    </div>
                </div>

                <!-- Descrição -->
                @if($vaga->descricao)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2">Descrição da Atividade</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $vaga->descricao }}</p>
                    </div>
                @endif

                <!-- Ações -->
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    @if(Auth::user()->tipo == 'garcom')
                        @if($vaga->status_vaga == 'aberta' && !$jaCandidatou)
                            <form action="{{ route('vagas.candidatar', $vaga->vaga_id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    Candidatar-se
                                </button>
                            </form>
                        @elseif($jaCandidatou)
                            <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 text-gray-600 text-sm font-semibold rounded-lg">
                                ✅ Candidatura enviada
                            </span>
                        @else
                            <span class="text-sm text-gray-400">Vaga encerrada</span>
                        @endif
                    @endif

                    @if(Auth::user()->tipo == 'restaurante')
                        <a href="{{ route('vagas.candidatos', $vaga->vaga_id) }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            Ver Candidatos ({{ $totalCandidatos }})
                        </a>

                        @if($vaga->status_vaga == 'aberta')
                            <form action="{{ route('vagas.fechar', $vaga->vaga_id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 text-sm font-semibold rounded-lg transition-colors ring-1 ring-red-200">
                                    Encerrar Vaga
                                </button>
                            </form>
                        @else
                            <form action="{{ route('vagas.reabrir', $vaga->vaga_id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-50 hover:bg-green-100 text-green-700 text-sm font-semibold rounded-lg transition-colors ring-1 ring-green-200">
                                    Reabrir Vaga
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
