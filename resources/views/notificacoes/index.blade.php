<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-semibold text-slate-700 leading-tight">Notificações</h2>
            @if($notificacoes->total() > 0)
                <form action="{{ route('notificacoes.todas') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="text-xs font-semibold text-orange-600 hover:text-orange-700 transition-colors px-3 py-1.5 rounded-lg hover:bg-orange-50">
                        Marcar todas como lidas
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="max-w-3xl space-y-3">

        @if(session('sucesso'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
                {{ session('sucesso') }}
            </div>
        @endif

        @forelse($notificacoes as $notif)
            @if($notif->link)
                <a href="{{ $notif->link }}" class="block">
            @else
                <div>
            @endif

            <div class="bg-white rounded-2xl border {{ $notif->lida ? 'border-slate-100' : 'border-orange-200 ring-1 ring-orange-100' }} shadow-sm p-5 transition-all hover:shadow-md">
                <div class="flex items-start gap-3">
                    <!-- Indicador lida/não lida -->
                    <div class="flex-shrink-0 mt-1">
                        @if(!$notif->lida)
                            <span class="w-2.5 h-2.5 rounded-full bg-orange-500 block"></span>
                        @else
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-200 block"></span>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <p class="text-sm font-semibold {{ $notif->lida ? 'text-slate-700' : 'text-slate-900' }}">{{ $notif->titulo }}</p>
                            <span class="text-xs text-slate-400 flex-shrink-0 mt-0.5">{{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-slate-500 mt-0.5 leading-relaxed">{{ $notif->mensagem }}</p>

                        @if($notif->link)
                            <span class="inline-flex items-center gap-1 mt-2 text-xs text-orange-600 font-medium">
                                Ver detalhes
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            @if($notif->link)
                </a>
            @else
                </div>
            @endif
        @empty
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center">
                <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900 mb-1">Nenhuma notificação</h3>
                <p class="text-sm text-slate-400">Voce esta em dia! Nenhuma notificacao por aqui.</p>
            </div>
        @endforelse

        @if($notificacoes->hasPages())
            <div class="mt-4">
                {{ $notificacoes->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
