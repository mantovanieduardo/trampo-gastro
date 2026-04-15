<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800 leading-tight">
                Nova Vaga para Garçom
            </h2>
            <a href="{{ route('vagas.index') }}" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
                &larr; Voltar para vagas
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl">

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 p-4 rounded-xl">
                <div class="flex gap-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-red-800 mb-1">Ops! Corrija os itens abaixo:</h3>
                        <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="p-8">
                <form action="{{ route('vagas.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label for="titulo" class="block text-sm font-semibold text-gray-700 mb-1.5">Título da Vaga</label>
                        <input type="text" name="titulo" id="titulo"
                               class="w-full border-gray-200 focus:border-amber-400 focus:ring-amber-400 rounded-lg shadow-sm text-sm"
                               placeholder="Ex: Garçom — Evento de Sábado"
                               value="{{ old('titulo') }}" required>
                        <p class="text-xs text-gray-400 mt-1.5">Seja claro e objetivo para atrair os melhores candidatos.</p>
                    </div>

                    <div class="mb-6">
                        <label for="descricao" class="block text-sm font-semibold text-gray-700 mb-1.5">Descrição da Atividade</label>
                        <textarea name="descricao" id="descricao" rows="4"
                                  class="w-full border-gray-200 focus:border-amber-400 focus:ring-amber-400 rounded-lg shadow-sm text-sm"
                                  placeholder="Ex: Servir bebidas, auxiliar na limpeza das mesas...">{{ old('descricao') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="valor_pago" class="block text-sm font-semibold text-gray-700 mb-1.5">Valor do Cachê (R$)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-400 text-sm">R$</span>
                                </div>
                                <input type="number" name="valor_pago" id="valor_pago" step="0.01"
                                       class="w-full pl-10 border-gray-200 focus:border-amber-400 focus:ring-amber-400 rounded-lg shadow-sm text-sm"
                                       value="{{ old('valor_pago') }}" required>
                            </div>
                        </div>

                        <div>
                            <label for="data_hora_inicio" class="block text-sm font-semibold text-gray-700 mb-1.5">Data e Hora de Início</label>
                            <input type="datetime-local" name="data_hora_inicio" id="data_hora_inicio"
                                   class="w-full border-gray-200 focus:border-amber-400 focus:ring-amber-400 rounded-lg shadow-sm text-sm"
                                   value="{{ old('data_hora_inicio') }}" required>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-5 border-t border-gray-100">
                        <a href="{{ route('vagas.index') }}"
                           class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit"
                                class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-6 rounded-lg shadow-sm transition-colors text-sm">
                            Publicar Vaga
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
