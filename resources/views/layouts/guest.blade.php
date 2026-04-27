<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Clima Laboral') }}</title>

    {{-- Fuentes --}}
    <style>
        @font-face {
            font-family: 'NT Somic';
            src: url('/fonts/ntsomic-regular.woff2') format('woff2');
            font-weight: 400;
        }
        @font-face {
            font-family: 'NT Somic';
            src: url('/fonts/ntsomic-bold.woff2') format('woff2');
            font-weight: 700;
        }
    </style>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="font-sans text-gray-900 antialiased bg-[#F9FAFB]">
    
    <div class="absolute top-0 left-0 w-full z-50">
        @include('partials.navigation')
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-20 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-xl border-t-4 border-[#F00000] sm:rounded-none">
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
</body>
</html>