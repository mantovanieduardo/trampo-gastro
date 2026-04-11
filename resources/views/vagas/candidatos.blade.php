<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Candidatos para: <span class="text-indigo-600">{{ $vaga->titulo_vaga }}</span>
            </h2>
            <a href="{{ route('vagas.index') }}" class="text-sm text-gray-500 hover:underline">
                &larr; Voltar para vagas
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('sucesso'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('sucesso') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome do Garçom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email de Contato</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ação</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($candidaturas as $candidato)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $candidato->nome_garcom }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $candidato->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($candidato->status == 'pendente')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Aguardando Aprovação
                                        </span>
                                    @elseif($candidato->status == 'aceito')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Contratado
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($candidato->status == 'pendente' && strtolower($vaga->status_vaga) == 'aberta')
                                        <form action="{{ route('candidaturas.aprovar', $candidato->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white py-1 px-3 rounded font-bold transition">
                                                ✅ Aprovar Garçom
                                            </button>
                                        </form>
                                    @elseif($candidato->status == 'aceito')
                                        <span class="text-gray-400 italic">Aprovado</span>
                                    @else
                                        <span class="text-gray-400 italic">Vaga Fechada</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">
                                    Nenhum garçom se candidatou para esta vaga ainda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>