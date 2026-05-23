<x-app-layout>
    <x-slot name="header">
        <h2 class="text-base font-semibold text-slate-700 leading-tight">Minha Agenda</h2>
    </x-slot>

    <div class="max-w-5xl">
        <div class="mb-6">
            <p class="text-sm text-slate-500">Vagas em que você foi aprovado pelos restaurantes.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($trabalhos as $trabalho)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    <!-- Barra de status topo -->
                    <div class="h-1 bg-emerald-500"></div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Confirmado
                            </span>
                            <span class="text-base font-bold text-orange-600">
                                R$ {{ number_format($trabalho->valor_diaria, 2, ',', '.') }}
                            </span>
                        </div>

                        <h4 class="text-base font-semibold text-slate-800 mb-3 leading-snug">{{ $trabalho->titulo_vaga }}</h4>

                        <div class="space-y-2 text-sm text-slate-500 mb-4">
                            <p class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                <a href="{{ route('restaurantes.show', $trabalho->restaurante_id) }}"
                                   class="hover:text-orange-600 transition-colors font-medium">
                                    {{ $trabalho->restaurante }}
                                </a>
                            </p>
                            <p class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                <span>{{ $trabalho->data_hora_inicio ? date('d/m/Y \à\s H:i', strtotime($trabalho->data_hora_inicio)) : 'A definir' }}</span>
                            </p>
                        </div>

                        <div class="space-y-2">
                            <!-- Chat -->
                            <a href="{{ route('mensagens.show', [$trabalho->vaga_id, $trabalho->restaurante_user_id]) }}"
                               class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition-colors min-h-[40px]">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                </svg>
                                Mensagens
                            </a>

                            <!-- Avaliar restaurante -->
                            @if(!in_array($trabalho->vaga_id, $avaliacoesFeitas))
                                <div x-data="{ open: false }">
                                    <button @click="open = true"
                                            class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold rounded-xl transition-all active:scale-95 min-h-[40px]">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        Avaliar Restaurante
                                    </button>

                                    <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
                                        <div @click.away="open = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6">
                                            <h3 class="text-base font-bold text-slate-900 mb-1">Avaliar {{ $trabalho->restaurante }}</h3>
                                            <p class="text-sm text-slate-500 mb-4">Como foi sua experiência neste trabalho?</p>

                                            <form action="{{ route('avaliacoes.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="vaga_id" value="{{ $trabalho->vaga_id }}">
                                                <input type="hidden" name="avaliado_id" value="{{ $trabalho->restaurante_user_id }}">
                                                <input type="hidden" name="tipo" value="garcom_avalia_restaurante">

                                                <div class="mb-4">
                                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nota</label>
                                                    <div class="flex gap-2" x-data="{ nota: 0 }">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <label class="cursor-pointer">
                                                                <input type="radio" name="nota" value="{{ $i }}" class="sr-only" required>
                                                                <svg @click="nota = {{ $i }}"
                                                                     class="w-8 h-8 transition-colors"
                                                                     :class="nota >= {{ $i }} ? 'text-amber-400' : 'text-slate-200'"
                                                                     fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            </label>
                                                        @endfor
                                                    </div>
                                                </div>

                                                <div class="mb-5">
                                                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Comentário (opcional)</label>
                                                    <textarea name="comentario" rows="3"
                                                              class="w-full border-slate-200 rounded-xl text-sm focus:border-orange-400 focus:ring-orange-400"
                                                              placeholder="Como foi o ambiente, organização..."></textarea>
                                                </div>

                                                <div class="flex gap-3 justify-end">
                                                    <button type="button" @click="open = false"
                                                            class="px-4 py-2 text-sm font-medium text-slate-500 hover:text-slate-700">
                                                        Cancelar
                                                    </button>
                                                    <button type="submit"
                                                            class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-xl transition-all active:scale-95">
                                                        Enviar Avaliação
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="text-xs text-center text-slate-400 italic py-1">Restaurante avaliado</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center">
                    <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-7 w-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-900 mb-1">Nenhum trabalho agendado</h3>
                    <p class="text-sm text-slate-400 mb-6">Você ainda não foi aprovado em nenhuma vaga. Continue se candidatando!</p>
                    <a href="{{ route('vagas.index') }}"
                       class="inline-flex items-center px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-md active:scale-95">
                        Procurar Vagas
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
