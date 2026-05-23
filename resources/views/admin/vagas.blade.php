<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-semibold text-slate-700 leading-tight">Vagas (Admin)</h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-400 hover:text-slate-600 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Painel Admin
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl space-y-4">

        <!-- Cards mobile -->
        <div class="md:hidden space-y-3">
            @forelse($vagas as $vaga)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <a href="{{ route('vagas.show', $vaga->vaga_id) }}"
                           class="font-semibold text-slate-900 hover:text-orange-600 transition-colors leading-tight text-sm">
                            {{ $vaga->titulo_vaga }}
                        </a>
                        @if($vaga->status_vaga == 'aberta')
                            <span class="flex-shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aberta
                            </span>
                        @else
                            <span class="flex-shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600 ring-1 ring-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Fechada
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <span class="font-medium text-orange-600">R$ {{ number_format($vaga->valor_diaria, 2, ',', '.') }}</span>
                        <span>{{ $vaga->restaurante }}</span>
                        <span>{{ \Carbon\Carbon::parse($vaga->created_at)->format('d/m/Y') }}</span>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center">
                    <p class="text-slate-400 text-sm">Nenhuma vaga encontrada.</p>
                </div>
            @endforelse
        </div>

        <!-- Tabela desktop -->
        <div class="hidden md:block bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Título</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Restaurante</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Valor</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Data</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($vagas as $vaga)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('vagas.show', $vaga->vaga_id) }}"
                                       class="text-sm font-medium text-slate-900 hover:text-orange-600 transition-colors">
                                        {{ $vaga->titulo_vaga }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $vaga->restaurante }}
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                    {{ \Carbon\Carbon::parse($vaga->created_at)->format('d/m/Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-14 text-center">
                                    <p class="text-slate-400 text-sm">Nenhuma vaga encontrada.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($vagas->hasPages())
            <div class="mt-4">
                {{ $vagas->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
