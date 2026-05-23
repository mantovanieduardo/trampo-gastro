<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800 leading-tight">Perfil do Garçom</h2>
            <a href="javascript:history.back()" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
                &larr; Voltar
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl space-y-5">

        @if(session('sucesso'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('sucesso') }}
            </div>
        @endif

        <!-- Card principal -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8">
            <div class="flex items-start gap-6">
                <!-- Avatar -->
                @if($garcom->foto_perfil)
                    <img src="{{ Storage::url($garcom->foto_perfil) }}"
                         alt="{{ $garcom->name }}"
                         class="w-16 h-16 rounded-full object-cover flex-shrink-0">
                @else
                    <div class="w-16 h-16 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl font-bold text-white">{{ strtoupper(substr($garcom->name, 0, 1)) }}</span>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl font-bold text-gray-900">{{ $garcom->name }}</h1>
                    <p class="text-sm text-gray-500">{{ $garcom->email }}</p>

                    <!-- Rating -->
                    @if($totalAvaliacao > 0)
                        <div class="flex items-center gap-2 mt-2">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= round($mediaAvaliacao) ? 'text-amber-400' : 'text-gray-200' }}"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm font-semibold text-gray-700">{{ number_format($mediaAvaliacao, 1) }}</span>
                            <span class="text-sm text-gray-400">({{ $totalAvaliacao }} avaliação{{ $totalAvaliacao != 1 ? 'ões' : '' }})</span>
                        </div>
                    @else
                        <p class="text-sm text-gray-400 mt-2">Sem avaliações ainda</p>
                    @endif
                </div>
            </div>

            <!-- Bio e experiência -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 pt-6 border-t border-gray-100">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Experiência</p>
                    <p class="text-sm text-gray-700">{{ $perfil->experiencia ?? 'Não informado' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Telefone</p>
                    <p class="text-sm text-gray-700">{{ $perfil->telefone ?? 'Não informado' }}</p>
                </div>
                @if(!empty($perfil->bio))
                    <div class="md:col-span-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Sobre</p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $perfil->bio }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Histórico de trabalhos -->
        @if($historico->count() > 0)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Histórico de Trabalhos</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($historico as $trabalho)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $trabalho->titulo_vaga }}</p>
                                <a href="{{ route('restaurantes.show', $trabalho->restaurante_id) }}"
                                   class="text-xs text-amber-600 hover:text-amber-700 transition-colors mt-0.5 block">
                                    {{ $trabalho->restaurante }}
                                </a>
                            </div>
                            <div class="text-right flex-shrink-0 ml-4">
                                <p class="text-sm font-semibold text-gray-800">R$ {{ number_format($trabalho->valor_diaria, 2, ',', '.') }}</p>
                                @if($trabalho->data_hora_inicio)
                                    <p class="text-xs text-gray-400">{{ date('d/m/Y', strtotime($trabalho->data_hora_inicio)) }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Avaliações recebidas -->
        @if($avaliacoes->count() > 0)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Avaliações Recebidas</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($avaliacoes as $avaliacao)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $avaliacao->nota ? 'text-amber-400' : 'text-gray-200' }}"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-400">{{ $avaliacao->created_at->format('d/m/Y') }}</span>
                            </div>
                            @if($avaliacao->comentario)
                                <p class="text-sm text-gray-600 italic">"{{ $avaliacao->comentario }}"</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
