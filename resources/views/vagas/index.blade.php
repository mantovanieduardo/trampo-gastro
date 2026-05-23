<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-base font-semibold text-slate-700 leading-tight">Vagas</h2>
            @if(Auth::user()->tipo == 'restaurante')
                <a href="{{ route('vagas.create') }}"
                   class="inline-flex items-center gap-1.5 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-xl transition-all shadow-sm hover:shadow-md active:scale-95 text-sm min-h-[36px]">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Nova Vaga
                </a>
            @endif
        </div>
    </x-slot>

    <div class="space-y-4 max-w-5xl">

        @if(session('sucesso'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
                {{ session('sucesso') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- Busca e filtros -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm" x-data="{ filtrosAbertos: false }">
            <form method="GET" action="{{ route('vagas.index') }}">
                <div class="p-4">
                    <!-- Busca full-width mobile -->
                    <div class="relative mb-3">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <input type="text" name="busca" value="{{ request('busca') }}"
                               placeholder="Buscar vagas..."
                               class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:border-orange-400 focus:ring-orange-400">
                    </div>

                    <!-- Toggle filtros mobile -->
                    <button type="button" @click="filtrosAbertos = !filtrosAbertos"
                            class="flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors md:hidden mb-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>
                        <span x-text="filtrosAbertos ? 'Ocultar filtros' : 'Filtros avançados'"></span>
                        <svg class="w-3.5 h-3.5 transition-transform" :class="filtrosAbertos ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    <!-- Filtros avançados (accordion mobile / sempre visível md+) -->
                    <div x-show="filtrosAbertos" x-transition class="md:hidden">
                        <div class="grid grid-cols-2 gap-2 mb-3">
                            <select name="status" class="border border-slate-200 rounded-xl text-sm px-3 py-2 focus:border-orange-400 focus:ring-orange-400 col-span-2">
                                <option value="">Todos os status</option>
                                <option value="aberta" {{ request('status') == 'aberta' ? 'selected' : '' }}>Abertas</option>
                                <option value="fechada" {{ request('status') == 'fechada' ? 'selected' : '' }}>Fechadas</option>
                            </select>
                            <input type="number" name="valor_min" value="{{ request('valor_min') }}"
                                   placeholder="Valor mín. (R$)"
                                   class="px-3 py-2 border border-slate-200 rounded-xl text-sm focus:border-orange-400 focus:ring-orange-400">
                            <input type="number" name="valor_max" value="{{ request('valor_max') }}"
                                   placeholder="Valor máx. (R$)"
                                   class="px-3 py-2 border border-slate-200 rounded-xl text-sm focus:border-orange-400 focus:ring-orange-400">
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Data início</label>
                                <input type="date" name="data_inicio" value="{{ request('data_inicio') }}"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:border-orange-400 focus:ring-orange-400">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Data fim</label>
                                <input type="date" name="data_fim" value="{{ request('data_fim') }}"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:border-orange-400 focus:ring-orange-400">
                            </div>
                        </div>
                    </div>

                    <!-- Filtros desktop sempre visíveis -->
                    <div class="hidden md:grid grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
                        <select name="status" class="border border-slate-200 rounded-xl text-sm px-3 py-2 focus:border-orange-400 focus:ring-orange-400">
                            <option value="">Todos os status</option>
                            <option value="aberta" {{ request('status') == 'aberta' ? 'selected' : '' }}>Abertas</option>
                            <option value="fechada" {{ request('status') == 'fechada' ? 'selected' : '' }}>Fechadas</option>
                        </select>
                        <div class="flex gap-2">
                            <input type="number" name="valor_min" value="{{ request('valor_min') }}"
                                   placeholder="Mín R$"
                                   class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:border-orange-400 focus:ring-orange-400">
                            <input type="number" name="valor_max" value="{{ request('valor_max') }}"
                                   placeholder="Máx R$"
                                   class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:border-orange-400 focus:ring-orange-400">
                        </div>
                        <div class="flex gap-2">
                            <input type="date" name="data_inicio" value="{{ request('data_inicio') }}"
                                   class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:border-orange-400 focus:ring-orange-400">
                            <input type="date" name="data_fim" value="{{ request('data_fim') }}"
                                   class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:border-orange-400 focus:ring-orange-400">
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit"
                                class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-xl transition-colors min-h-[40px]">
                            Filtrar
                        </button>
                        @if(request('busca') || request('status') || request('valor_min') || request('valor_max') || request('data_inicio') || request('data_fim'))
                            <a href="{{ route('vagas.index') }}" class="px-4 py-2 text-sm text-slate-500 hover:text-slate-700 transition-colors">
                                Limpar
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Cards mobile (hidden md+) -->
        <div class="md:hidden space-y-3">
            @forelse($vagas as $vaga)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <a href="{{ route('vagas.show', $vaga->vaga_id) }}"
                           class="font-semibold text-slate-900 hover:text-orange-600 transition-colors leading-tight">
                            {{ $vaga->titulo_vaga }}
                        </a>
                        @if($vaga->status_vaga == 'aberta')
                            <span class="flex-shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Aberta
                            </span>
                        @else
                            <span class="flex-shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600 ring-1 ring-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                Fechada
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center justify-between mb-3">
                        <p class="text-lg font-bold text-orange-600">R$ {{ number_format($vaga->valor_diaria, 2, ',', '.') }}</p>
                        <p class="text-xs text-slate-400">{{ $vaga->created_at->format('d/m/Y') }}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('vagas.show', $vaga->vaga_id) }}"
                           class="flex-1 text-center py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition-colors min-h-[44px] flex items-center justify-center">
                            Ver detalhes
                        </a>

                        @if(Auth::user()->tipo == 'garcom')
                            @if(isset($candidaturasPendentes[$vaga->vaga_id]))
                                <form action="{{ route('candidaturas.cancelar', $candidaturasPendentes[$vaga->vaga_id]) }}" method="POST" class="flex-1">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Cancelar candidatura?')"
                                            class="w-full py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-sm font-semibold rounded-xl transition-colors ring-1 ring-rose-200 min-h-[44px]">
                                        Cancelar
                                    </button>
                                </form>
                            @elseif($vaga->status_vaga == 'aberta')
                                <form action="{{ route('vagas.candidatar', $vaga->vaga_id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                            class="w-full py-2.5 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-md active:scale-95 min-h-[44px]">
                                        Candidatar-se
                                    </button>
                                </form>
                            @endif
                        @elseif(Auth::user()->tipo == 'restaurante')
                            <a href="{{ route('vagas.candidatos', $vaga->vaga_id) }}"
                               class="flex-1 text-center py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-xl transition-colors min-h-[44px] flex items-center justify-center">
                                Candidatos
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center">
                    <p class="text-slate-400 text-sm">Nenhuma vaga encontrada.</p>
                </div>
            @endforelse
        </div>

        <!-- Tabela desktop (hidden md-) -->
        <div class="hidden md:block bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Título</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Valor</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Vagas</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Data</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($vagas as $vaga)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('vagas.show', $vaga->vaga_id) }}" class="text-sm font-medium text-slate-900 hover:text-orange-600 transition-colors">
                                        {{ $vaga->titulo_vaga }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-orange-600">
                                    R$ {{ number_format($vaga->valor_diaria, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($vaga->status_vaga == 'aberta')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aberta
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600 ring-1 ring-slate-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Fechada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    @php
                                        $aprovadosCount = \Illuminate\Support\Facades\DB::table('candidaturas')
                                            ->where('vaga_id', $vaga->vaga_id)
                                            ->where('status', 'aceito')
                                            ->count();
                                        $vagasNec = $vaga->vagas_necessarias ?? 1;
                                    @endphp
                                    <span class="text-xs font-medium {{ $aprovadosCount >= $vagasNec ? 'text-emerald-600' : 'text-amber-600' }}">
                                        {{ $aprovadosCount }}/{{ $vagasNec }} preenchidas
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                    {{ $vaga->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <a href="{{ route('vagas.show', $vaga->vaga_id) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-colors">
                                            Ver detalhes
                                        </a>

                                        @if(Auth::user()->tipo == 'garcom')
                                            @if(isset($candidaturasPendentes[$vaga->vaga_id]))
                                                <form action="{{ route('candidaturas.cancelar', $candidaturasPendentes[$vaga->vaga_id]) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Cancelar candidatura?')"
                                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-semibold rounded-lg transition-colors ring-1 ring-rose-200">
                                                        Cancelar
                                                    </button>
                                                </form>
                                            @elseif($vaga->status_vaga == 'aberta')
                                                <form action="{{ route('vagas.candidatar', $vaga->vaga_id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-semibold rounded-lg transition-all active:scale-95">
                                                        Candidatar-se
                                                    </button>
                                                </form>
                                            @endif
                                        @elseif(Auth::user()->tipo == 'restaurante')
                                            <a href="{{ route('vagas.candidatos', $vaga->vaga_id) }}"
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-lg transition-colors">
                                                Candidatos
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-14 text-center">
                                    <p class="text-slate-400 text-sm">Nenhuma vaga encontrada.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginação -->
        @if($vagas->hasPages())
            <div class="mt-4">
                {{ $vagas->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
