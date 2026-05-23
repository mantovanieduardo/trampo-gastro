<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-semibold text-slate-700 leading-tight">Perfil do Restaurante</h2>
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

        <!-- Card principal -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="h-24 bg-gradient-to-r from-slate-900 to-slate-800"></div>

            <div class="px-6 pb-6">
                <!-- Logo/avatar centralizado -->
                <div class="flex justify-center -mt-12 mb-4">
                    @if($restaurante->foto)
                        <img src="{{ Storage::url($restaurante->foto) }}"
                             alt="{{ $restaurante->nome_fantasia }}"
                             class="w-20 h-20 rounded-2xl object-cover ring-4 ring-white shadow-md">
                    @else
                        <div class="w-20 h-20 rounded-2xl bg-orange-500 flex items-center justify-center ring-4 ring-white shadow-md">
                            <span class="text-3xl font-bold text-white">{{ strtoupper(substr($restaurante->nome_fantasia, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>

                <div class="text-center mb-5">
                    <h1 class="text-xl font-bold text-slate-900">{{ $restaurante->nome_fantasia }}</h1>

                    @if($mediaAvaliacao)
                        <div class="flex items-center justify-center gap-2 mt-2">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= round($mediaAvaliacao) ? 'text-amber-400' : 'text-slate-200' }}"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm font-semibold text-slate-700">{{ number_format($mediaAvaliacao, 1) }}</span>
                            <span class="text-sm text-slate-400">({{ $avaliacoes->count() }} avaliação{{ $avaliacoes->count() != 1 ? 'ões' : '' }})</span>
                        </div>
                    @else
                        <p class="text-sm text-slate-400 mt-2">Sem avaliações ainda</p>
                    @endif
                </div>

                @if($restaurante->descricao)
                    <div class="mb-5 pb-5 border-b border-slate-100">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Sobre</p>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $restaurante->descricao }}</p>
                    </div>
                @endif

                <!-- Stats em grid 2x2 mobile -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 pt-4 border-t border-slate-100 text-center">
                    <div>
                        <p class="text-2xl font-bold text-slate-900">{{ $totalVagas }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Total de vagas</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-emerald-600">{{ $vagasAbertas }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Vagas abertas</p>
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <p class="text-2xl font-bold text-orange-600">{{ $garConsContratados }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">Garçons contratados</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Editar perfil (só o próprio restaurante) -->
        @if(Auth::user()->tipo == 'restaurante')
            @php $minhaRestaurante = \Illuminate\Support\Facades\DB::table('restaurantes')->where('usuario_id', Auth::id())->first(); @endphp
            @if($minhaRestaurante && $minhaRestaurante->restaurante_id == $restaurante->restaurante_id)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h2 class="text-sm font-semibold text-slate-900">Editar Perfil do Restaurante</h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('restaurante.perfil.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PATCH')
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Descrição</label>
                                <textarea name="descricao" rows="4"
                                          class="w-full border-slate-200 rounded-xl text-sm focus:border-orange-400 focus:ring-orange-400"
                                          placeholder="Conte sobre o seu restaurante...">{{ $restaurante->descricao }}</textarea>
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Foto do Restaurante</label>
                                <input type="file" name="foto" accept="image/*"
                                       class="w-full border border-slate-200 rounded-xl text-sm px-3 py-2 focus:border-orange-400 focus:ring-orange-400">
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                        class="px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-md active:scale-95">
                                    Salvar Perfil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endif

        <!-- Vagas recentes -->
        @if($vagasPassadas->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-900">Vagas Recentes</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach($vagasPassadas as $vagaPassada)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-slate-900 truncate">{{ $vagaPassada->titulo_vaga }}</p>
                                @if($vagaPassada->data_hora_inicio)
                                    <p class="text-xs text-slate-500 mt-0.5">{{ date('d/m/Y', strtotime($vagaPassada->data_hora_inicio)) }}</p>
                                @endif
                            </div>
                            <span class="flex-shrink-0 ml-4 inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600 ring-1 ring-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Encerrada
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Avaliações dos garçons -->
        @if($avaliacoes->count() > 0)
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-900">Avaliações dos Garçons</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach($avaliacoes as $avaliacao)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $avaliacao->nota ? 'text-amber-400' : 'text-slate-200' }}"
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    @if($avaliacao->avaliador)
                                        <span class="text-xs text-slate-500">por {{ $avaliacao->avaliador->name }}</span>
                                    @endif
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
