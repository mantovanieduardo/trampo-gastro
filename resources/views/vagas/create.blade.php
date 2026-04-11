<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nova Vaga para Garçom') }}
            </h2>
            <a href="{{ route('vagas.index') }}" class="text-sm text-gray-500 hover:underline">
                &larr; Voltar para vagas
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Ops! Encontramos alguns problemas:</h3>
                            <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('vagas.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="titulo" class="block text-sm font-semibold text-gray-700 mb-2">Título da Vaga</label>
                            <input type="text" name="titulo" id="titulo" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" placeholder="Ex: Garçom - Evento de Sábado" value="{{ old('titulo') }}" required>
                            <p class="text-xs text-gray-500 mt-1">Seja claro e objetivo para atrair os melhores candidatos.</p>
                        </div>

                        <div class="mb-6">
                            <label for="descricao" class="block text-sm font-semibold text-gray-700 mb-2">Descrição da Atividade</label>
                            <textarea name="descricao" id="descricao" rows="4" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" placeholder="Ex: Servir bebidas, auxiliar na limpeza das mesas...">{{ old('descricao') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label for="valor_pago" class="block text-sm font-semibold text-gray-700 mb-2">Valor do Cache (R$)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">R$</span>
                                    </div>
                                    <input type="number" name="valor_pago" id="valor_pago" step="0.01" class="w-full pl-10 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" value="{{ old('valor_pago') }}" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="data_hora_inicio" class="block text-sm font-semibold text-gray-700 mb-2">Data e Hora de Início</label>
                                <input type="datetime-local" name="data_hora_inicio" id="data_hora_inicio" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" value="{{ old('data_hora_inicio') }}" required>
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                            <a href="{{ route('vagas.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 mr-4 transition">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md shadow-sm transition">
                                Publicar Vaga
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>