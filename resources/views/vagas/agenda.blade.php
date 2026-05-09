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

                        <div class="space-y-1.5 text-sm text-gray-500 mb-4">
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
                                <span>{{ $trabalho->data_hora_inicio ? date('d/m/Y \à\s H:i', strtotime($trabalho->data_hora_inicio)) : 'A definir' }}</span>
                            </p>
                        </div>

                        <!-- Botão de avaliar -->
                        @if(!in_array($trabalho->vaga_id, $avaliacoesFeitas))
                            <div x-data="{ open: false }">
                                <button @click="open = true"
                                        class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-semibold rounded-lg transition-colors ring-1 ring-amber-200">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Avaliar Restaurante
                                </button>

                                <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
                                    <div @click.away="open = false" class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
                                        <h3 class="text-base font-bold text-gray-900 mb-1">Avaliar {{ $trabalho->restaurante }}</h3>
                                        <p class="text-sm text-gray-500 mb-4">Como foi sua experiência neste trabalho?</p>

                                        <form action="{{ route('avaliacoes.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="vaga_id" value="{{ $trabalho->vaga_id }}">
                                            <input type="hidden" name="avaliado_id" value="{{ $trabalho->restaurante_user_id }}">
                                            <input type="hidden" name="tipo" value="garcom_avalia_restaurante">

                                            <div class="mb-4">
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nota</label>
                                                <div class="flex gap-2" x-data="{ nota: 0 }">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <label class="cursor-pointer">
                                                            <input type="radio" name="nota" value="{{ $i }}" class="sr-only" required>
                                                            <svg @click="nota = {{ $i }}"
                                                                 class="w-8 h-8 transition-colors"
                                                                 :class="nota >= {{ $i }} ? 'text-amber-400' : 'text-gray-200'"
                                                                 fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        </label>
                                                    @endfor
                                                </div>
                                            </div>

                                            <div class="mb-5">
                                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Comentário (opcional)</label>
                                                <textarea name="comentario" rows="3"
                                                          class="w-full border-gray-200 rounded-lg text-sm focus:border-amber-400 focus:ring-amber-400"
                                                          placeholder="Como foi o ambiente, organização..."></textarea>
                                            </div>

                                            <div class="flex gap-3 justify-end">
                                                <button type="button" @click="open = false"
                                                        class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                                                    Cancelar
                                                </button>
                                                <button type="submit"
                                                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                                    Enviar Avaliação
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-xs text-center text-gray-400 italic">Restaurante avaliado ✓</p>
                        @endif
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
