<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-semibold text-slate-700 leading-tight">Detalhes da Vaga</h2>
            <a href="{{ route('vagas.index') }}" class="text-sm text-slate-400 hover:text-slate-600 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Vagas
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl space-y-4">

        @if(session('sucesso'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
                {{ session('sucesso') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Card topo: valor + status em destaque mobile -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <!-- Barra de status top -->
            <div class="h-1.5 {{ $vaga->status_vaga == 'aberta' ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>

            <div class="p-6">
                <!-- Header: título + valor + status -->
                <div class="flex items-start justify-between gap-4 mb-5">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl font-bold text-slate-900 leading-tight mb-1">{{ $vaga->titulo_vaga }}</h1>
                        @if($restaurante)
                            <p class="text-sm text-slate-500">por <span class="font-medium text-slate-700">{{ $restaurante->nome_fantasia }}</span></p>
                        @endif
                    </div>
                    <div class="flex-shrink-0 text-right">
                        <p class="text-2xl font-bold text-orange-600">R$ {{ number_format($vaga->valor_diaria, 2, ',', '.') }}</p>
                        @if($vaga->status_vaga == 'aberta')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aberta
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600 ring-1 ring-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Fechada
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Info rápida grid 2x2 mobile -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-5 pb-5 border-b border-slate-100">
                    @if($vaga->data_hora_inicio)
                        <div>
                            <p class="text-xs text-slate-400 font-medium mb-0.5">Data e Hora</p>
                            <p class="text-sm font-semibold text-slate-800">
                                {{ $vaga->data_hora_inicio->format('d/m/Y \à\s H:i') }}
                            </p>
                        </div>
                    @endif
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Tipo de Contrato</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $vaga->tipo_contrato }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-medium mb-0.5">Candidatos</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $totalCandidatos }} inscrito(s)</p>
                    </div>
                </div>

                <!-- Descrição -->
                @if($vaga->descricao)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-slate-700 mb-2">Descrição da Atividade</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $vaga->descricao }}</p>
                    </div>
                @endif

                <!-- Ações desktop (hidden mobile — FAB mobile abaixo) -->
                <div class="hidden md:flex items-center gap-3 pt-4 border-t border-slate-100">
                    @if(Auth::user()->tipo == 'garcom')
                        @if($vaga->status_vaga == 'aberta' && !$jaCandidatou)
                            <form action="{{ route('vagas.candidatar', $vaga->vaga_id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-md active:scale-95">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    Candidatar-se
                                </button>
                            </form>
                        @elseif($jaCandidatou)
                            <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-50 text-emerald-700 text-sm font-semibold rounded-xl ring-1 ring-emerald-200">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                                Candidatura enviada
                            </span>
                        @else
                            <span class="text-sm text-slate-400">Vaga encerrada</span>
                        @endif
                    @endif

                    @if(Auth::user()->tipo == 'restaurante')
                        <a href="{{ route('vagas.candidatos', $vaga->vaga_id) }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-xl transition-colors">
                            Ver Candidatos ({{ $totalCandidatos }})
                        </a>

                        @if($vaga->status_vaga == 'aberta')
                            <form action="{{ route('vagas.fechar', $vaga->vaga_id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-700 text-sm font-semibold rounded-xl transition-colors ring-1 ring-rose-200">
                                    Encerrar Vaga
                                </button>
                            </form>
                        @else
                            <form action="{{ route('vagas.reabrir', $vaga->vaga_id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-sm font-semibold rounded-xl transition-colors ring-1 ring-emerald-200">
                                    Reabrir Vaga
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Barra de ação mobile (fixed bottom / FAB) -->
        <div class="md:hidden fixed bottom-20 inset-x-0 px-4 z-20">
            @if(Auth::user()->tipo == 'garcom')
                @if($vaga->status_vaga == 'aberta' && !$jaCandidatou)
                    <form action="{{ route('vagas.candidatar', $vaga->vaga_id) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white text-base font-bold rounded-2xl transition-all shadow-xl shadow-orange-500/30 active:scale-95">
                            Candidatar-se a esta vaga
                        </button>
                    </form>
                @elseif($jaCandidatou)
                    <div class="w-full py-4 bg-emerald-50 text-emerald-700 text-base font-bold rounded-2xl ring-1 ring-emerald-200 text-center">
                        Candidatura enviada
                    </div>
                @endif
            @endif
            @if(Auth::user()->tipo == 'restaurante')
                <a href="{{ route('vagas.candidatos', $vaga->vaga_id) }}"
                   class="block w-full py-4 bg-slate-900 text-white text-base font-bold rounded-2xl shadow-xl text-center">
                    Ver Candidatos ({{ $totalCandidatos }})
                </a>
            @endif
        </div>

    </div>
</x-app-layout>
