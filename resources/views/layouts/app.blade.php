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
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('vagas.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                              {{ request()->routeIs('vagas.index') ? 'bg-amber-500/10 text-amber-400 ring-1 ring-amber-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                        </svg>
                        Ver Vagas
                    </a>

                    @if(Auth::user()->tipo == 'restaurante')
                        <div class="pt-5 pb-1.5 px-3">
                            <p class="text-[10px] font-semibold text-gray-600 uppercase tracking-widest">Restaurante</p>
                        </div>
                        <a href="{{ route('vagas.create') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                                  {{ request()->routeIs('vagas.create') ? 'bg-amber-500/10 text-amber-400 ring-1 ring-amber-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Nova Vaga
                        </a>
                    @endif

                    @if(Auth::user()->tipo == 'garcom')
                        <div class="pt-5 pb-1.5 px-3">
                            <p class="text-[10px] font-semibold text-gray-600 uppercase tracking-widest">Minhas Atividades</p>
                        </div>
                        <a href="{{ route('agenda.index') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                                  {{ request()->routeIs('agenda.index') ? 'bg-amber-500/10 text-amber-400 ring-1 ring-amber-500/20' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            Minha Agenda
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
                        <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2 text-xs text-gray-500 hover:text-red-400 hover:bg-red-500/5 rounded-lg transition-colors">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                            Sair do Sistema
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
