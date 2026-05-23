<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-800 leading-tight">Vagas Publicadas</h2>
            @if(Auth::user()->tipo == 'restaurante')
                <a href="{{ route('vagas.create') }}"
                   class="inline-flex items-center gap-1.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-lg transition text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Nova Vaga
                </a>
            @endif
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

        <!-- Busca e filtros -->
        <form method="GET" action="{{ route('vagas.index') }}" class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-3">
                <div class="relative sm:col-span-2 lg:col-span-1">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input type="text" name="busca" value="{{ request('busca') }}"
                           placeholder="Buscar por título..."
                           class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:border-amber-400 focus:ring-amber-400">
                </div>
                <select name="status" class="border border-gray-200 rounded-lg text-sm px-3 py-2 focus:border-amber-400 focus:ring-amber-400">
                    <option value="">Todos os status</option>
                    <option value="aberta" {{ request('status') == 'aberta' ? 'selected' : '' }}>Abertas</option>
                    <option value="fechada" {{ request('status') == 'fechada' ? 'selected' : '' }}>Fechadas</option>
                </select>
                <div class="grid grid-cols-2 gap-2">
                    <input type="number" name="valor_min" value="{{ request('valor_min') }}"
                           placeholder="Valor mín."
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:border-amber-400 focus:ring-amber-400">
                    <input type="number" name="valor_max" value="{{ request('valor_max') }}"
                           placeholder="Valor máx."
                           class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:border-amber-400 focus:ring-amber-400">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Data início</label>
                        <input type="date" name="data_inicio" value="{{ request('data_inicio') }}"
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Data fim</label>
                        <input type="date" name="data_fim" value="{{ request('data_fim') }}"
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:border-amber-400 focus:ring-amber-400">
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold rounded-lg transition-colors">
                    Filtrar
                </button>
                @if(request('busca') || request('status') || request('valor_min') || request('valor_max') || request('data_inicio') || request('data_fim'))
                    <a href="{{ route('vagas.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700">
                        Limpar filtros
                    </a>
                @endif
            </div>
        </form>

        <!-- Tabela -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
            <table class="min-w-full divide-y divide-gray-100">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Título</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Valor</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Vagas</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Data</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($vagas as $vaga)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('vagas.show', $vaga->vaga_id) }}" class="text-sm font-medium text-gray-900 hover:text-amber-600 transition-colors">
                                    {{ $vaga->titulo_vaga }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-700">
                                R$ {{ number_format($vaga->valor_diaria, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($vaga->status_vaga == 'aberta')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-700 ring-1 ring-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aberta
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600 ring-1 ring-gray-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Fechada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                @php
                                    $aprovadosCount = \Illuminate\Support\Facades\DB::table('candidaturas')
                                        ->where('vaga_id', $vaga->vaga_id)
                                        ->where('status', 'aceito')
                                        ->count();
                                    $vagasNec = $vaga->vagas_necessarias ?? 1;
                                @endphp
                                <span class="text-xs font-medium {{ $aprovadosCount >= $vagasNec ? 'text-green-600' : 'text-amber-600' }}">
                                    {{ $aprovadosCount }}/{{ $vagasNec }} preenchidas
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 hidden md:table-cell">
                                {{ $vaga->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <a href="{{ route('vagas.show', $vaga->vaga_id) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg transition-colors">
                                        Ver detalhes
                                    </a>

                                    @if(Auth::user()->tipo == 'garcom')
                                        @if(isset($candidaturasPendentes[$vaga->vaga_id]))
                                            {{-- Garçom já se candidatou - mostrar botão cancelar --}}
                                            <form action="{{ route('candidaturas.cancelar', $candidaturasPendentes[$vaga->vaga_id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Cancelar candidatura?')"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold rounded-lg transition-colors ring-1 ring-red-200">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                    </svg>
                                                    Cancelar
                                                </button>
                                            </form>
                                        @elseif($vaga->status_vaga == 'aberta')
                                            <form action="{{ route('vagas.candidatar', $vaga->vaga_id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg transition-colors">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                                    </svg>
                                                    Candidatar-se
                                                </button>
                                            </form>
                                        @endif
                                    @elseif(Auth::user()->tipo == 'restaurante')
                                        <a href="{{ route('vagas.candidatos', $vaga->vaga_id) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-800 hover:bg-gray-900 text-white text-xs font-semibold rounded-lg transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                            </svg>
                                            Candidatos
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">
                                <p class="text-gray-400 text-sm">Nenhuma vaga encontrada.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        @if($vagas->hasPages())
            <div class="mt-4">
                {{ $vagas->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
