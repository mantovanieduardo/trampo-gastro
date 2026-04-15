<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800 leading-tight">
                Vagas Publicadas
            </h2>

            @if(Auth::user()->tipo == 'restaurante')
                <a href="{{ route('vagas.create') }}"
                   class="inline-flex items-center gap-1.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-lg transition text-sm">
                    + Nova Vaga
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-2">
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
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Título</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Valor</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Criado em</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($vagas as $vaga)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $vaga->titulo_vaga }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">
                                R$ {{ number_format($vaga->valor_diaria, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($vaga->status_vaga == 'aberta')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-700 ring-1 ring-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Aberta
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600 ring-1 ring-gray-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        {{ ucfirst($vaga->status_vaga) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $vaga->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(Auth::user()->tipo == 'garcom' && $vaga->status_vaga == 'aberta')
                                    <form action="{{ route('vagas.candidatar', $vaga->vaga_id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition-colors">
                                            Candidatar-se
                                        </button>
                                    </form>
                                @elseif(Auth::user()->tipo == 'restaurante')
                                    <a href="{{ route('vagas.candidatos', $vaga->vaga_id) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg transition-colors">
                                        👥 Ver Candidatos
                                    </a>
                                @else
                                    <span class="text-gray-400 italic text-xs">Indisponível</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center">
                                <p class="text-gray-400 text-sm">Nenhuma vaga cadastrada ainda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
