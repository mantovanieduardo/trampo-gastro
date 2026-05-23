<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#f97316">
        <title>{{ config('app.name', 'Trampo Gastro') }}</title>
        <link rel="manifest" href="/manifest.json">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', function() {
                    navigator.serviceWorker.register('/sw.js').catch(function() {});
                });
            }
        </script>
    </head>
    <body class="font-sans antialiased text-slate-900 bg-slate-50">
        @php
            $notifCount = Auth::check() ? \App\Models\Notificacao::where('user_id', Auth::id())->where('lida', false)->count() : 0;
        @endphp

        <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">

            <!-- Overlay mobile -->
            <div x-show="sidebarOpen"
                 x-transition.opacity
                 @click="sidebarOpen = false"
                 class="fixed inset-0 z-20 bg-black/60 lg:hidden"></div>

            <!-- Sidebar — hidden on mobile, visible on lg+ -->
            <aside class="hidden lg:flex fixed inset-y-0 left-0 z-30 w-64 bg-slate-950 flex-col">

                <!-- Brand -->
                <div class="px-6 py-5 border-b border-white/5">
                    <h1 class="text-base font-bold tracking-tight">
                        <span class="bg-gradient-to-r from-orange-400 to-orange-500 bg-clip-text text-transparent">TRAMPO</span>
                        <span class="text-white"> GASTRO</span>
                    </h1>
                    <p class="text-xs text-slate-500 mt-0.5">Plataforma de freelas</p>
                </div>

                <!-- Nav -->
                <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                              {{ request()->routeIs('dashboard') ? 'bg-orange-500/10 text-orange-400 ring-1 ring-orange-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('vagas.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                              {{ request()->routeIs('vagas.index') || request()->routeIs('vagas.show') ? 'bg-orange-500/10 text-orange-400 ring-1 ring-orange-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                        </svg>
                        Ver Vagas
                    </a>

                    <a href="{{ route('notificacoes.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                              {{ request()->routeIs('notificacoes.*') ? 'bg-orange-500/10 text-orange-400 ring-1 ring-orange-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                        <div class="relative flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                            @if($notifCount > 0)
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-rose-500 rounded-full flex items-center justify-center text-[9px] font-bold text-white">
                                    {{ $notifCount > 9 ? '9+' : $notifCount }}
                                </span>
                            @endif
                        </div>
                        Notificações
                        @if($notifCount > 0)
                            <span class="ml-auto bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $notifCount > 9 ? '9+' : $notifCount }}</span>
                        @endif
                    </a>

                    @if(Auth::user()->tipo == 'restaurante')
                        <div class="pt-5 pb-1.5 px-3">
                            <p class="text-[10px] font-semibold text-slate-600 uppercase tracking-widest">Restaurante</p>
                        </div>
                        <a href="{{ route('vagas.create') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                                  {{ request()->routeIs('vagas.create') ? 'bg-orange-500/10 text-orange-400 ring-1 ring-orange-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Nova Vaga
                        </a>
                    @endif

                    @if(Auth::user()->tipo == 'garcom')
                        <div class="pt-5 pb-1.5 px-3">
                            <p class="text-[10px] font-semibold text-slate-600 uppercase tracking-widest">Minhas Atividades</p>
                        </div>
                        <a href="{{ route('agenda.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                                  {{ request()->routeIs('agenda.index') ? 'bg-orange-500/10 text-orange-400 ring-1 ring-orange-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            Minha Agenda
                        </a>
                    @endif

                    @if(Auth::user()->is_admin)
                        <div class="pt-5 pb-1.5 px-3">
                            <p class="text-[10px] font-semibold text-slate-600 uppercase tracking-widest">Administração</p>
                        </div>
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                                  {{ request()->routeIs('admin.*') ? 'bg-orange-500/10 text-orange-400 ring-1 ring-orange-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            Painel Admin
                        </a>
                    @endif
                </nav>

                <!-- User / Logout -->
                <div class="p-3 border-t border-white/5">
                    <div class="flex items-center gap-3 px-3 py-2 mb-1 rounded-lg">
                        @if(Auth::user()->foto_perfil)
                            <img src="{{ Storage::url(Auth::user()->foto_perfil) }}"
                                 alt="{{ Auth::user()->name }}"
                                 class="w-8 h-8 rounded-full object-cover flex-shrink-0">
                        @else
                            <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center flex-shrink-0">
                                <span class="text-sm font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                        @endif
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                            <a href="{{ route('profile.edit') }}" class="text-xs text-slate-500 hover:text-orange-400 transition-colors">Meu Perfil</a>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs text-slate-500 hover:text-rose-400 hover:bg-rose-500/5 rounded-lg transition-colors">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                            Sair do Sistema
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main content -->
            <div class="flex-1 flex flex-col min-w-0 lg:ml-64">

                <!-- Header -->
                <header class="bg-white/80 backdrop-blur-sm border-b border-slate-100 sticky top-0 z-10 px-4 py-3 lg:px-6 lg:py-4">
                    <div class="flex items-center gap-3">
                        <!-- Logo mobile (lg:hidden) -->
                        <div class="flex-1 flex items-center gap-3 lg:hidden">
                            <a href="{{ route('dashboard') }}" class="font-bold text-sm tracking-tight">
                                <span class="bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">TRAMPO</span>
                                <span class="text-slate-900"> GASTRO</span>
                            </a>
                        </div>

                        <!-- Breadcrumb / slot header desktop -->
                        <div class="hidden lg:flex flex-1 min-w-0">
                            @isset($header)
                                {{ $header }}
                            @endisset
                        </div>

                        <!-- Notification bell -->
                        <div class="relative">
                            <a href="{{ route('notificacoes.index') }}"
                               class="flex items-center justify-center w-9 h-9 rounded-xl text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                </svg>
                                @if($notifCount > 0)
                                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-rose-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">
                                        {{ $notifCount > 9 ? '9+' : $notifCount }}
                                    </span>
                                @endif
                            </a>
                        </div>

                        <!-- Avatar -->
                        <a href="{{ route('profile.edit') }}" class="flex-shrink-0">
                            @if(Auth::user()->foto_perfil)
                                <img src="{{ Storage::url(Auth::user()->foto_perfil) }}"
                                     alt="{{ Auth::user()->name }}"
                                     class="w-8 h-8 rounded-full object-cover ring-2 ring-slate-100">
                            @else
                                <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center ring-2 ring-orange-100">
                                    <span class="text-xs font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </a>
                    </div>

                    <!-- Header slot mobile -->
                    @isset($header)
                        <div class="lg:hidden mt-2 pt-2 border-t border-slate-100">
                            {{ $header }}
                        </div>
                    @endisset
                </header>

                <!-- Main -->
                <main class="flex-1 p-4 lg:p-8 pb-24 lg:pb-8">
                    {{ $slot }}
                </main>
            </div>

            <!-- Bottom Navigation — mobile only (lg:hidden) -->
            <nav class="lg:hidden fixed bottom-0 inset-x-0 z-30 bg-white border-t border-slate-100 safe-area-bottom">
                <div class="flex items-center justify-around px-2 py-2">

                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                       class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl min-w-[56px] transition-colors
                              {{ request()->routeIs('dashboard') ? 'text-orange-500' : 'text-slate-400' }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        <span class="text-[10px] font-medium">Início</span>
                        @if(request()->routeIs('dashboard'))
                            <span class="w-1 h-1 rounded-full bg-orange-500 block"></span>
                        @endif
                    </a>

                    <!-- Vagas -->
                    <a href="{{ route('vagas.index') }}"
                       class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl min-w-[56px] transition-colors
                              {{ request()->routeIs('vagas.index') || request()->routeIs('vagas.show') ? 'text-orange-500' : 'text-slate-400' }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                        </svg>
                        <span class="text-[10px] font-medium">Vagas</span>
                        @if(request()->routeIs('vagas.index') || request()->routeIs('vagas.show'))
                            <span class="w-1 h-1 rounded-full bg-orange-500 block"></span>
                        @endif
                    </a>

                    @if(Auth::user()->tipo == 'restaurante')
                        <!-- Nova Vaga (restaurante) -->
                        <a href="{{ route('vagas.create') }}"
                           class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl min-w-[56px] transition-colors
                                  {{ request()->routeIs('vagas.create') ? 'text-orange-500' : 'text-slate-400' }}">
                            <div class="w-10 h-10 bg-orange-500 rounded-2xl flex items-center justify-center -mt-5 shadow-lg shadow-orange-500/30">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-medium mt-0.5">Nova</span>
                        </a>
                    @else
                        <!-- Agenda (garçom) -->
                        <a href="{{ route('agenda.index') }}"
                           class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl min-w-[56px] transition-colors
                                  {{ request()->routeIs('agenda.index') ? 'text-orange-500' : 'text-slate-400' }}">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            <span class="text-[10px] font-medium">Agenda</span>
                            @if(request()->routeIs('agenda.index'))
                                <span class="w-1 h-1 rounded-full bg-orange-500 block"></span>
                            @endif
                        </a>
                    @endif

                    <!-- Perfil -->
                    <a href="{{ route('profile.edit') }}"
                       class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl min-w-[56px] transition-colors
                              {{ request()->routeIs('profile.*') ? 'text-orange-500' : 'text-slate-400' }}">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span class="text-[10px] font-medium">Perfil</span>
                        @if(request()->routeIs('profile.*'))
                            <span class="w-1 h-1 rounded-full bg-orange-500 block"></span>
                        @endif
                    </a>

                </div>
            </nav>

        </div>
    </body>
</html>
