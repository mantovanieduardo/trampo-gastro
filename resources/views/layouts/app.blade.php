<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="min-h-screen bg-gray-50 flex">
            
            <aside class="w-64 bg-white border-r border-gray-200 flex flex-col shadow-sm">
                <div class="p-6">
                    <h1 class="text-xl font-bold text-gray-800 tracking-tight">TRAMPO GASTRO</h1>
                </div>
                
                <nav class="flex-1 px-4 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-blue-600 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="mr-3">🏠</span> Dashboard
                    </a>

                    <a href="{{ route('vagas.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('vagas.index') ? 'bg-gray-100 text-blue-600 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="mr-3">📋</span> Ver Vagas
                    </a>

                    @if(Auth::user()->tipo == 'restaurante')
                        <div class="pt-4 pb-2 px-4 text-[10px] font-semibold text-gray-400 uppercase">Restaurante</div>
                        <a href="{{ route('vagas.create') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('vagas.create') ? 'bg-gray-100 text-blue-600 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="mr-3">➕</span> Nova Vaga
                        </a>
                    @endif

                    @if(Auth::user()->tipo == 'garcom')
                        <div class="pt-4 pb-2 px-4 text-[10px] font-semibold text-gray-400 uppercase">Minhas Atividades</div>
                        <a href="{{ route('agenda.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('agenda.index') ? 'bg-gray-100 text-blue-600 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span class="mr-3">📅</span> Minha Agenda
                        </a>
                    @endif
                </nav>
                </nav>

                <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                    <div class="px-2 mb-3">
                        <p class="text-sm font-bold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                        <a href="{{ route('profile.edit') }}" class="text-xs text-blue-500 hover:underline">Meu Perfil</a>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-2 py-2 text-xs text-red-500 hover:bg-red-50 rounded transition">
                            🚪 Sair do Sistema
                        </button>
                    </form>
                </div>
            </aside>

            <div class="flex-1 flex flex-col">
                @isset($header)
                    <header class="bg-white border-b border-gray-200 py-4 px-8">
                        <h2 class="text-lg font-semibold text-gray-700">{{ $header }}</h2>
                    </header>
                @endisset
                <main class="p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>