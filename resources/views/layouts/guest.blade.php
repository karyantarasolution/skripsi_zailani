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
    <body class="font-sans text-white antialiased">
        <div class="min-h-screen cosmic-body">
            <div class="cosmic-orb w-96 h-96 bg-purple-600/10 -top-48 -left-48" style="animation-delay: 0s;"></div>
            <div class="cosmic-orb w-80 h-80 bg-cyan-500/8 top-1/3 -right-40" style="animation-delay: 5s;"></div>
            {{ $slot }}
        </div>
    </body>
</html>