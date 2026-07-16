<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="icon" type="image/png" href="{{ asset('images/orbit.png') }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Orbit Print') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased cosmic-body">
        {{-- Floating Orbs --}}
        <div class="cosmic-orb w-96 h-96 bg-purple-600/10 -top-48 -left-48" style="animation-delay: 0s;"></div>
        <div class="cosmic-orb w-80 h-80 bg-cyan-500/8 top-1/3 -right-40" style="animation-delay: 5s;"></div>
        <div class="cosmic-orb w-64 h-64 bg-pink-500/6 bottom-20 left-1/4" style="animation-delay: 10s;"></div>

        <div class="min-h-screen flex">
            @include('layouts.navigation')

            <div class="flex-1 lg:ml-64">
                @isset($header)
                    <header class="border-b border-white/5 bg-white/[0.02] backdrop-blur-xl">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
