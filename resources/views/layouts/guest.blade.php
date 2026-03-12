<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
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
    @livewireStyles
</head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
