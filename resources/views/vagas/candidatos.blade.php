<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 leading-tight">
                    Candidatos
                </h2>
                <p class="text-sm text-gray-400 mt-0.5">{{ $vaga->titulo_vaga }}</p>
            </div>
            <a href="{{ route('vagas.index') }}" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
                &larr; Voltar para vagas
            </a>
        </div>
    </x-slot>

    <div>
        @if(session('sucesso'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('sucesso') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
            <table class="min-w-full divide-y divide-gray-100">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nome do Garçom</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email de Contato</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ação</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($candidaturas as $candidato)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $candidato->nome_garcom }}
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
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($candidato->status == 'pendente' && strtolower($vaga->status_vaga) == 'aberta')
                                    <form action="{{ route('candidaturas.aprovar', $candidato->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white py-1.5 px-3 rounded-lg text-xs font-semibold transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                            Aprovar Garçom
                                        </button>
                                    </form>
                                @elseif($candidato->status == 'aceito')
                                    <span class="text-gray-400 text-xs">Aprovado</span>
                                @else
                                    <span class="text-gray-400 text-xs">Vaga Fechada</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-14 text-center">
                                <p class="text-gray-400 text-sm">Nenhum garçom se candidatou para esta vaga ainda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
