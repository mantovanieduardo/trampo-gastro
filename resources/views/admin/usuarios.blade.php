<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-semibold text-slate-700 leading-tight">Usuários</h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-400 hover:text-slate-600 transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Painel Admin
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl space-y-4">

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

        <!-- Cards mobile -->
        <div class="md:hidden space-y-3">
            @forelse($usuarios as $usuario)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4">
                    <div class="flex items-center gap-3 mb-3">
                        @if($usuario->foto_perfil)
                            <img src="{{ Storage::url($usuario->foto_perfil) }}"
                                 alt="{{ $usuario->name }}"
                                 class="w-11 h-11 rounded-full object-cover flex-shrink-0">
                        @else
                            <div class="w-11 h-11 rounded-full bg-orange-500 flex items-center justify-center flex-shrink-0">
                                <span class="text-base font-bold text-white">{{ strtoupper(substr($usuario->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-900 text-sm truncate">{{ $usuario->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ $usuario->email }}</p>
                        </div>
                        <div class="flex-shrink-0 flex flex-col items-end gap-1">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full
                                {{ $usuario->tipo == 'restaurante' ? 'bg-orange-50 text-orange-700 ring-1 ring-orange-200' : 'bg-slate-100 text-slate-600 ring-1 ring-slate-200' }}">
                                {{ ucfirst($usuario->tipo) }}
                            </span>
                            @if($usuario->is_admin)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-violet-50 text-violet-700 ring-1 ring-violet-200">
                                    Admin
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-slate-400">Cadastrado em {{ $usuario->created_at->format('d/m/Y') }}</p>
                        @if($usuario->id !== Auth::id())
                            <form action="{{ route('admin.toggle-admin', $usuario->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg transition-colors
                                            {{ $usuario->is_admin ? 'bg-rose-50 hover:bg-rose-100 text-rose-600 ring-1 ring-rose-200' : 'bg-violet-50 hover:bg-violet-100 text-violet-600 ring-1 ring-violet-200' }}">
                                    {{ $usuario->is_admin ? 'Remover Admin' : 'Tornar Admin' }}
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-slate-400 italic">Você</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center">
                    <p class="text-slate-400 text-sm">Nenhum usuário encontrado.</p>
                </div>
            @endforelse
        </div>

        <!-- Tabela desktop -->
        <div class="hidden md:block bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Usuário</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Admin</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Cadastro</th>
                            <th class="px-6 py-3.5 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($usuarios as $usuario)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @if($usuario->foto_perfil)
                                            <img src="{{ Storage::url($usuario->foto_perfil) }}"
                                                 alt="{{ $usuario->name }}"
                                                 class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center flex-shrink-0">
                                                <span class="text-xs font-bold text-white">{{ strtoupper(substr($usuario->name, 0, 1)) }}</span>
                                            </div>
                                        @endif
                                        <span class="text-sm font-medium text-slate-900">{{ $usuario->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $usuario->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-semibold rounded-full
                                        {{ $usuario->tipo == 'restaurante' ? 'bg-orange-50 text-orange-700 ring-1 ring-orange-200' : 'bg-slate-100 text-slate-600 ring-1 ring-slate-200' }}">
                                        {{ ucfirst($usuario->tipo) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($usuario->is_admin)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold rounded-full bg-violet-50 text-violet-700 ring-1 ring-violet-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-violet-500"></span>
                                            Admin
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                    {{ $usuario->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($usuario->id !== Auth::id())
                                        <form action="{{ route('admin.toggle-admin', $usuario->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-lg transition-colors
                                                        {{ $usuario->is_admin ? 'bg-rose-50 hover:bg-rose-100 text-rose-600 ring-1 ring-rose-200' : 'bg-violet-50 hover:bg-violet-100 text-violet-600 ring-1 ring-violet-200' }}">
                                                {{ $usuario->is_admin ? 'Remover Admin' : 'Tornar Admin' }}
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Você</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-14 text-center">
                                    <p class="text-slate-400 text-sm">Nenhum usuário encontrado.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($usuarios->hasPages())
            <div class="mt-4">
                {{ $usuarios->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
