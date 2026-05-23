<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-semibold text-slate-700 leading-tight">Perfil do Garçom</h2>
            <a href="javascript:history.back()" class="text-sm text-slate-400 hover:text-slate-600 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl space-y-4">

        @if(session('sucesso'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
                {{ session('sucesso') }}
            </div>
        @endif

        <!-- Card principal com avatar centralizado mobile -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <!-- Header colorido -->
            <div class="h-24 bg-gradient-to-r from-slate-900 to-slate-800"></div>

            <div class="px-6 pb-6">
                <!-- Avatar sobrepondo o header -->
                <div class="flex justify-center -mt-12 mb-4">
                    @if($garcom->foto_perfil)
                        <img src="{{ Storage::url($garcom->foto_perfil) }}"
                             alt="{{ $garcom->name }}"
                             class="w-20 h-20 rounded-2xl object-cover ring-4 ring-white shadow-md">
                    @else
                        <div class="w-20 h-20 rounded-2xl bg-orange-500 flex items-center justify-center ring-4 ring-white shadow-md">
                            <span class="text-3xl font-bold text-white">{{ strtoupper(substr($garcom->name, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>

                <div class="text-center mb-5">
                    <h1 class="text-xl font-bold text-slate-900">{{ $garcom->name }}</h1>
                    <p class="text-sm text-slate-500 mt-0.5">{{ $garcom->email }}</p>

                    <!-- Rating -->
                    @if($totalAvaliacao > 0)
                        <div class="flex items-center justify-center gap-2 mt-3">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= round($mediaAvaliacao) ? 'text-amber-400' : 'text-slate-200' }}"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm font-semibold text-slate-700">{{ number_format($mediaAvaliacao, 1) }}</span>
                            <span class="text-sm text-slate-400">({{ $totalAvaliacao }} avaliação{{ $totalAvaliacao != 1 ? 'ões' : '' }})</span>
                        </div>
                    @else
                        <p class="text-sm text-slate-400 mt-2">Sem avaliações ainda</p>
                    @endif
                </div>

                <!-- Info em grid 2 colunas -->
                <div class="grid grid-cols-2 gap-4 pt-5 border-t border-slate-100">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Experiência</p>
                        <p class="text-sm text-slate-700">{{ $perfil->experiencia ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Telefone</p>
                        <p class="text-sm text-slate-700">{{ $perfil->telefone ?? 'Não informado' }}</p>
                    </div>
                    @if(!empty($perfil->bio))
                        <div class="col-span-2">
                            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Sobre</p>
                            <p class="text-sm text-slate-700 leading-relaxed">{{ $perfil->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Histórico de trabalhos -->
        @if($historico->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-900">Histórico de Trabalhos</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach($historico as $trabalho)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-slate-900 truncate">{{ $trabalho->titulo_vaga }}</p>
                                <a href="{{ route('restaurantes.show', $trabalho->restaurante_id) }}"
                                   class="text-xs text-orange-600 hover:text-orange-700 transition-colors mt-0.5 block">
                                    {{ $trabalho->restaurante }}
                                </a>
                            </div>
                            <div class="text-right flex-shrink-0 ml-4">
                                <p class="text-sm font-semibold text-slate-800">R$ {{ number_format($trabalho->valor_diaria, 2, ',', '.') }}</p>
                                @if($trabalho->data_hora_inicio)
                                    <p class="text-xs text-slate-400">{{ date('d/m/Y', strtotime($trabalho->data_hora_inicio)) }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Avaliações recebidas -->
        @if($avaliacoes->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-900">Avaliações Recebidas</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach($avaliacoes as $avaliacao)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $avaliacao->nota ? 'text-amber-400' : 'text-slate-200' }}"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-xs text-slate-400">{{ $avaliacao->created_at->format('d/m/Y') }}</span>
                            </div>
                            @if($avaliacao->comentario)
                                <p class="text-sm text-slate-600 italic">"{{ $avaliacao->comentario }}"</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
