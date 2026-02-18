<!DOCTYPE html>
<html lang="es">
<head>
    <style>
        @font-face {
            font-family: 'NT Somic';
            src: url('/resources/fonts/NTSomic-Regular.ttf') format('ttf');
            font-weight: 400;
        }
        @font-face {
            font-family: 'NT Somic';
            src: url('/resources/fonts/NTSomic-Bold.ttf') format('ttf');
            font-weight: 700;
        }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['NT Somic', 'sans-serif'],
                    },
                    colors: {
                        brandRed: '#F00000',
                        brandPink: '#FFE5E5',
                    }
                }
            }
        }
    </script>
    <meta charset="UTF-8">
    <title>Clima Laboral</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="flex flex-col min-h-screen bg-[#FFFFFF]">
    
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



