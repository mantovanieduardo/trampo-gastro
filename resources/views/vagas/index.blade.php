<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Vagas Publicadas') }}
            </h2>
            
            @if(Auth::user()->tipo == 'restaurante')
                <a href="{{ route('vagas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition text-sm">
                    + Nova Vaga
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-2">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criado em</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($vagas as $vaga)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ $vaga->titulo_vaga }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                R$ {{ number_format($vaga->valor_diaria, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vaga->status_vaga == 'aberta' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($vaga->status_vaga) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $vaga->created_at->format('d/m/Y H:i') }}
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(Auth::user()->tipo == 'garcom' && $vaga->status_vaga == 'aberta')
                                    <form action="{{ route('vagas.candidatar', $vaga->vaga_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-900 font-bold">
                                            Candidatar-se
                                        </button>
                                    </form>
                                @elseif(Auth::user()->tipo == 'restaurante')
                                    <a href="{{ route('vagas.candidatos', $vaga->vaga_id) }}" class="bg-indigo-100 text-indigo-700 hover:bg-indigo-200 border border-indigo-200 font-bold py-1 px-3 rounded text-xs transition inline-flex items-center">
                                    <span>👥 Ver Candidatos</span>
                                @else
                                    <span class="text-gray-400 italic text-xs">Indisponível</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                Nenhuma vaga cadastrada ainda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>