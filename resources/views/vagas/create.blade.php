<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-semibold text-slate-700 leading-tight">Nova Vaga</h2>
            <a href="{{ route('vagas.index') }}" class="text-sm text-slate-400 hover:text-slate-600 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Vagas
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl">

        @if ($errors->any())
            <div class="mb-6 bg-rose-50 border border-rose-200 p-4 rounded-2xl">
                <div class="flex gap-3">
                    <svg class="h-5 w-5 text-rose-400 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-semibold text-rose-800 mb-1">Corrija os itens abaixo:</h3>
                        <ul class="list-disc list-inside text-sm text-rose-600 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm">
            <div class="p-6 lg:p-8">
                <form action="{{ route('vagas.store') }}" method="POST">
                    @csrf

                    <div class="space-y-5 mb-8">
                        <div>
                            <label for="titulo" class="block text-sm font-semibold text-slate-700 mb-2">Título da Vaga</label>
                            <input type="text" name="titulo" id="titulo"
                                   class="w-full border-slate-200 focus:border-orange-400 focus:ring-orange-400 rounded-xl shadow-sm text-sm py-3"
                                   placeholder="Ex: Garçom — Evento de Sábado"
                                   value="{{ old('titulo') }}" required>
                            <p class="text-xs text-slate-400 mt-1.5">Seja claro e objetivo para atrair os melhores candidatos.</p>
                        </div>

                        <div>
                            <label for="descricao" class="block text-sm font-semibold text-slate-700 mb-2">Descrição da Atividade</label>
                            <textarea name="descricao" id="descricao" rows="4"
                                      class="w-full border-slate-200 focus:border-orange-400 focus:ring-orange-400 rounded-xl shadow-sm text-sm"
                                      placeholder="Ex: Servir bebidas, auxiliar na limpeza das mesas...">{{ old('descricao') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="valor_pago" class="block text-sm font-semibold text-slate-700 mb-2">Valor do Cachê (R$)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <span class="text-slate-400 text-sm font-medium">R$</span>
                                    </div>
                                    <input type="number" name="valor_pago" id="valor_pago" step="0.01"
                                           class="w-full pl-10 border-slate-200 focus:border-orange-400 focus:ring-orange-400 rounded-xl shadow-sm text-sm py-3"
                                           value="{{ old('valor_pago') }}" required>
                                </div>
                            </div>

                            <div>
                                <label for="data_hora_inicio" class="block text-sm font-semibold text-slate-700 mb-2">Data e Hora de Início</label>
                                <input type="datetime-local" name="data_hora_inicio" id="data_hora_inicio"
                                       class="w-full border-slate-200 focus:border-orange-400 focus:ring-orange-400 rounded-xl shadow-sm text-sm py-3"
                                       value="{{ old('data_hora_inicio') }}" required>
                            </div>
                        </div>

                        <div>
                            <label for="vagas_necessarias" class="block text-sm font-semibold text-slate-700 mb-2">Número de Vagas</label>
                            <input type="number" name="vagas_necessarias" id="vagas_necessarias" min="1" max="100"
                                   class="w-full md:w-40 border-slate-200 focus:border-orange-400 focus:ring-orange-400 rounded-xl shadow-sm text-sm py-3"
                                   value="{{ old('vagas_necessarias', 1) }}">
                            <p class="text-xs text-slate-400 mt-1.5">Quantos garçons você precisa para este turno?</p>
                        </div>
                    </div>

                    <!-- Footer sticky mobile -->
                    <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-100 md:static md:bg-transparent md:p-0">
                        <a href="{{ route('vagas.index') }}"
                           class="text-sm font-medium text-slate-500 hover:text-slate-700 transition-colors px-4 py-2.5">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm transition-all hover:shadow-md active:scale-95 text-sm min-h-[44px]">
                            Publicar Vaga
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
