<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-800 leading-tight">Painel Administrativo</h2>
    </x-slot>

    <div class="space-y-6">

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Usuários</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalUsers }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $totalGarcons }} garçons / {{ $totalRestaurantes }} restaurantes</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Vagas</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalVagas }}</p>
                <p class="text-xs text-green-500 mt-1">{{ $vagasAbertas }} abertas</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Candidaturas</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalCandidaturas }}</p>
                <p class="text-xs text-amber-500 mt-1">{{ $candidaturasAceitas }} aceitas</p>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Receita Total</p>
                <p class="text-3xl font-bold text-gray-900">R$ {{ number_format($receitaTotal, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">valor das diárias pagas</p>
            </div>
        </div>

        <!-- Links rápidos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('admin.usuarios') }}"
               class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:border-amber-300 hover:shadow-md transition-all group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                        <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-gray-900">Gerenciar Usuários</p>
                        <p class="text-sm text-gray-400">Ver e gerenciar todos os usuários</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.vagas') }}"
               class="bg-white rounded-xl border border-gray-200 shadow-sm p-6 hover:border-amber-300 hover:shadow-md transition-all group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                        <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-semibold text-gray-900">Gerenciar Vagas</p>
                        <p class="text-sm text-gray-400">Ver todas as vagas publicadas</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
</x-app-layout>
