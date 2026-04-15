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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

            <!-- Brand -->
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                    <span class="text-amber-500">TRAMPO</span> GASTRO
                </h1>
                <p class="text-sm text-gray-500 mt-1">Plataforma de freelas para restaurantes</p>
            </div>

            <!-- Card -->
            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-sm overflow-hidden sm:rounded-xl border border-gray-100">
                {{ $slot }}
            </div>

        </div>
    </body>
</html>
