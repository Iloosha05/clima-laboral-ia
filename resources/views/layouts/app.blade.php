<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clima Laboral</title>

    {{-- Fuentes --}}
    <style>
        @font-face {
            font-family: 'NT Somic';
            src: url('/fonts/NTSomic-Regular.ttf') format('ttf');
            font-weight: 400;
        }
        @font-face {
            font-family: 'NT Somic';
            src: url('/fonts/NTSomic-Bold.ttf') format('ttf');
            font-weight: 700;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-screen bg-[#FFFFFF] font-sans">
    
    {{-- Header --}}
    @include('partials.navigation')

    {{-- Content --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')
</body>
</html>