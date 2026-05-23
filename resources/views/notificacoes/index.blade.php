<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800 leading-tight">Notificações</h2>
            @if($notificacoes->total() > 0)
                <form action="{{ route('notificacoes.todas') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                        Marcar todas como lidas
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="max-w-3xl space-y-3">

        @if(session('sucesso'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('sucesso') }}
            </div>
        @endif

        @forelse($notificacoes as $notif)
            <div class="bg-white rounded-xl border {{ $notif->lida ? 'border-gray-200' : 'border-amber-300 ring-1 ring-amber-200' }} shadow-sm p-5 transition-all">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 mt-0.5">
                        @if(!$notif->lida)
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-400 block mt-1"></span>
                        @else
                            <span class="w-2.5 h-2.5 rounded-full bg-gray-200 block mt-1"></span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-sm font-semibold text-gray-900">{{ $notif->titulo }}</p>
                            <span class="text-xs text-gray-400 flex-shrink-0">{{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-0.5">{{ $notif->mensagem }}</p>
                        @if($notif->link)
                            <a href="{{ $notif->link }}"
                               class="inline-flex items-center gap-1 mt-2 text-xs text-amber-600 hover:text-amber-700 font-medium transition-colors">
                                Ver detalhes
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-12 text-center">
                <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900 mb-1">Nenhuma notificação</h3>
                <p class="text-sm text-gray-400">Você está em dia! Nenhuma notificação por aqui.</p>
            </div>
        @endforelse

        @if($notificacoes->hasPages())
            <div class="mt-4">
                {{ $notificacoes->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
