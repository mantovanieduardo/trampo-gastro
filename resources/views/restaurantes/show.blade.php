<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800 leading-tight">Perfil do Restaurante</h2>
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
                @if($restaurante->foto)
                    <img src="{{ Storage::url($restaurante->foto) }}"
                         alt="{{ $restaurante->nome_fantasia }}"
                         class="w-16 h-16 rounded-full object-cover flex-shrink-0">
                @else
                    <div class="w-16 h-16 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl font-bold text-white">{{ strtoupper(substr($restaurante->nome_fantasia, 0, 1)) }}</span>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl font-bold text-gray-900">{{ $restaurante->nome_fantasia }}</h1>

                    @if($mediaAvaliacao)
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
                            <span class="text-sm text-gray-400">({{ $avaliacoes->count() }} avaliação{{ $avaliacoes->count() != 1 ? 'ões' : '' }})</span>
                        </div>
                    @else
                        <p class="text-sm text-gray-400 mt-2">Sem avaliações ainda</p>
                    @endif
                </div>
            </div>

            @if($restaurante->descricao)
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Sobre</p>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $restaurante->descricao }}</p>
                </div>
            @endif

            <!-- Stats -->
            <div class="mt-6 pt-6 border-t border-gray-100 grid grid-cols-3 gap-4 text-center">
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalVagas }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Total de vagas</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-green-600">{{ $vagasAbertas }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Vagas abertas</p>
                </div>
                <div>
                    <p class="text-2xl font-bold text-amber-600">{{ $garConsContratados }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Garçons contratados</p>
                </div>
            </div>
        </div>

        <!-- Formulário editar perfil (só o próprio restaurante) -->
        @if(Auth::user()->tipo == 'restaurante')
            @php $minhaRestaurante = \Illuminate\Support\Facades\DB::table('restaurantes')->where('usuario_id', Auth::id())->first(); @endphp
            @if($minhaRestaurante && $minhaRestaurante->restaurante_id == $restaurante->restaurante_id)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-sm font-semibold text-gray-900">Editar Perfil do Restaurante</h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('restaurante.perfil.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Descrição</label>
                                <textarea name="descricao" rows="4"
                                          class="w-full border-gray-200 rounded-lg text-sm focus:border-amber-400 focus:ring-amber-400"
                                          placeholder="Conte sobre o seu restaurante...">{{ $restaurante->descricao }}</textarea>
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Foto do Restaurante</label>
                                <input type="file" name="foto" accept="image/*"
                                       class="w-full border border-gray-200 rounded-lg text-sm px-3 py-2">
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                    Salvar Perfil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endif

        <!-- Vagas passadas -->
        @if($vagasPassadas->count() > 0)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Vagas Recentes</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($vagasPassadas as $vagaPassada)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $vagaPassada->titulo_vaga }}</p>
                                @if($vagaPassada->data_hora_inicio)
                                    <p class="text-xs text-gray-500 mt-0.5">{{ date('d/m/Y', strtotime($vagaPassada->data_hora_inicio)) }}</p>
                                @endif
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600 ring-1 ring-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Encerrada
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Avaliações recebidas -->
        @if($avaliacoes->count() > 0)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-sm font-semibold text-gray-900">Avaliações dos Garçons</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($avaliacoes as $avaliacao)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $avaliacao->nota ? 'text-amber-400' : 'text-gray-200' }}"
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    @if($avaliacao->avaliador)
                                        <span class="text-xs text-gray-500">por {{ $avaliacao->avaliador->name }}</span>
                                    @endif
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
