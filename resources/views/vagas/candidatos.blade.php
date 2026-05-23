<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 leading-tight">Candidatos</h2>
                <p class="text-sm text-gray-400 mt-0.5">
                    {{ $vaga->titulo_vaga }}
                    &mdash;
                    <span class="{{ $aprovados >= ($vaga->vagas_necessarias ?? 1) ? 'text-green-600' : 'text-amber-600' }} font-medium">
                        {{ $aprovados }}/{{ $vaga->vagas_necessarias ?? 1 }} vagas preenchidas
                    </span>
                </p>
            </div>
            <a href="{{ route('vagas.index') }}" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
                &larr; Voltar para vagas
            </a>
        </div>
    </x-slot>

    <div class="space-y-4">

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

        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
            <table class="min-w-full divide-y divide-gray-100">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Garçom</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($candidaturas as $candidato)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('garcons.show', $candidato->user_id) }}"
                                   class="flex items-center gap-3 group">
                                    @if($candidato->foto_perfil)
                                        <img src="{{ Storage::url($candidato->foto_perfil) }}"
                                             alt="{{ $candidato->nome_garcom }}"
                                             class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-100 transition-colors">
                                            <span class="text-xs font-bold text-gray-600 group-hover:text-amber-700">
                                                {{ strtoupper(substr($candidato->nome_garcom, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    <span class="text-sm font-medium text-gray-900 group-hover:text-amber-600 transition-colors">
                                        {{ $candidato->nome_garcom }}
                                    </span>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $candidato->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($candidato->status == 'pendente')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span>
                                        Aguardando
                                    </span>
                                @elseif($candidato->status == 'aceito')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-700 ring-1 ring-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Contratado
                                    </span>
                                @elseif($candidato->status == 'recusado')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-red-50 text-red-700 ring-1 ring-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Recusado
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2 flex-wrap">
                                    @if($candidato->status == 'pendente' && strtolower($vaga->status_vaga) == 'aberta')
                                        <form action="{{ route('candidaturas.aprovar', $candidato->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white py-1.5 px-3 rounded-lg text-xs font-semibold transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                                </svg>
                                                Aprovar
                                            </button>
                                        </form>
                                        <form action="{{ route('candidaturas.recusar', $candidato->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    onclick="return confirm('Recusar este candidato?')"
                                                    class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 py-1.5 px-3 rounded-lg text-xs font-semibold transition-colors ring-1 ring-red-200">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                </svg>
                                                Recusar
                                            </button>
                                        </form>
                                    @elseif($candidato->status == 'aceito')
                                        @if(!in_array($candidato->user_id, $avaliacoesFeitas))
                                            <!-- Modal de avaliação -->
                                            <div x-data="{ open: false }">
                                                <button @click="open = true"
                                                        class="inline-flex items-center gap-1.5 bg-amber-500 hover:bg-amber-600 text-white py-1.5 px-3 rounded-lg text-xs font-semibold transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                    Avaliar
                                                </button>

                                                <!-- Modal -->
                                                <div x-show="open" x-transition class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
                                                    <div @click.away="open = false" class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
                                                        <h3 class="text-base font-bold text-gray-900 mb-1">Avaliar {{ $candidato->nome_garcom }}</h3>
                                                        <p class="text-sm text-gray-500 mb-4">Dê uma nota para o trabalho deste garçom.</p>

                                                        <form action="{{ route('avaliacoes.store') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="vaga_id" value="{{ $vaga->vaga_id }}">
                                                            <input type="hidden" name="avaliado_id" value="{{ $candidato->user_id }}">
                                                            <input type="hidden" name="tipo" value="restaurante_avalia_garcom">

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
                                                                          placeholder="Como foi o trabalho deste garçom?"></textarea>
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
                                            <span class="text-xs text-gray-400 italic">Avaliado</span>
                                        @endif
                                        <!-- Botão mensagem para aprovados -->
                                        <a href="{{ route('mensagens.show', [$vaga->vaga_id, $candidato->user_id]) }}"
                                           class="inline-flex items-center gap-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 py-1.5 px-3 rounded-lg text-xs font-semibold transition-colors ring-1 ring-blue-200">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                            </svg>
                                            Mensagem
                                        </a>
                                    @else
                                        @if($candidato->status != 'recusado')
                                            <span class="text-gray-400 text-xs">Vaga fechada</span>
                                        @endif
                                    @endif

                                    <a href="{{ route('garcons.show', $candidato->user_id) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg transition-colors">
                                        Ver perfil
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-14 text-center">
                                <p class="text-gray-400 text-sm">Nenhum garçom se candidatou ainda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
