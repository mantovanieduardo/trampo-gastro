<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50">
        <div class="min-h-screen flex">

            <!-- Sidebar -->
            <aside class="w-64 bg-gray-900 flex flex-col flex-shrink-0">

                <!-- Brand -->
                <div class="px-6 py-5 border-b border-white/5">
                    <h1 class="text-base font-bold text-white tracking-tight">
                        <span class="text-amber-400">TRAMPO</span> GASTRO
                    </h1>
                    <p class="text-xs text-gray-500 mt-0.5">Plataforma de freelas</p>
                </div>

                <!-- Nav -->
                <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                              {{ request()->routeIs('dashboard') ? 'bg-amber-500/10 text-amber-400 ring-1 ring-amber-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                        <span>🏠</span> Dashboard
                    </a>

                    <a href="{{ route('vagas.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                              {{ request()->routeIs('vagas.index') ? 'bg-amber-500/10 text-amber-400 ring-1 ring-amber-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                        <span>📋</span> Ver Vagas
                    </a>

                    @if(Auth::user()->tipo == 'restaurante')
                        <div class="pt-5 pb-1.5 px-3">
                            <p class="text-[10px] font-semibold text-gray-600 uppercase tracking-widest">Restaurante</p>
                        </div>
                        <a href="{{ route('vagas.create') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                                  {{ request()->routeIs('vagas.create') ? 'bg-amber-500/10 text-amber-400 ring-1 ring-amber-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            <span>➕</span> Nova Vaga
                        </a>
                    @endif

                    @if(Auth::user()->tipo == 'garcom')
                        <div class="pt-5 pb-1.5 px-3">
                            <p class="text-[10px] font-semibold text-gray-600 uppercase tracking-widest">Minhas Atividades</p>
                        </div>
                        <a href="{{ route('agenda.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                                  {{ request()->routeIs('agenda.index') ? 'bg-amber-500/10 text-amber-400 ring-1 ring-amber-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            <span>📅</span> Minha Agenda
                        </a>
                    @endif
                </nav>

                <!-- User / Logout -->
                <div class="p-3 border-t border-white/5">
                    <div class="flex items-center gap-3 px-3 py-2 mb-1 rounded-lg">
                        <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0">
                            <span class="text-sm font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                            <a href="{{ route('profile.edit') }}" class="text-xs text-gray-500 hover:text-amber-400 transition-colors">Meu Perfil</a>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-3 py-2 text-xs text-gray-500 hover:text-red-400 hover:bg-red-500/5 rounded-lg transition-colors">
                            🚪 Sair do Sistema
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main content -->
            <div class="flex-1 flex flex-col min-w-0">
                @isset($header)
                    <header class="bg-white border-b border-gray-200 py-4 px-8 sticky top-0 z-10">
                        {{ $header }}
                    </header>
                @endisset
                <main class="p-8 flex-1">
                    {{ $slot }}
                </main>
            </div>

        </div>
    </body>
</html>
