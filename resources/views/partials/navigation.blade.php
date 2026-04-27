@php
    $links = [
        ['name' => 'Inicio', 'url' => url('/'), 'active' => request()->is('/')]
    ];

    if (Auth::check()) {
        $dashRoute = Auth::user()->role === 'hr' ? route('hr.dashboard') : route('dashboard');
        $links[] = [
            'name' => 'Dashboard', 
            'url' => $dashRoute, 
            'active' => request()->routeIs('dashboard') || request()->routeIs('hr.dashboard')
        ];
    } else {
        $links[] = ['name' => 'Login', 'url' => route('login'), 'active' => request()->routeIs('login')];
        $links[] = ['name' => 'Registro', 'url' => route('register'), 'active' => request()->routeIs('register')];
    }
@endphp

<header x-data="{ open: false }" class="bg-white py-4 px-8 shadow-sm relative z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        
        {{-- Logotipo Principal --}}
        <div class="flex items-end text-3xl font-bold tracking-tighter z-50">    
            <a href="{{ url('/') }}" wire:navigate class="leading-none">
                <img src="/images/logo1.svg" alt="Logo" class="h-8 block">
            </a>
            <img src="/images/logo2.svg" alt="Logo2" class="h-4 ml-1 mb-[2px]"> 
        </div>

        {{-- Menu tipo escritorio --}}
        <nav class="!hidden md:!flex gap-8 text-lg font-medium items-center uppercase tracking-wider">
            @foreach($links as $link)
                <a href="{{ $link['url'] }}" 
                   wire:navigate
                   wire:key="nav-link-desktop-{{ Str::slug($link['name']) }}"
                   class="relative py-2 transition-colors duration-300 group font-bold {{ $link['active'] ? 'text-[#F00000]' : 'text-[#000000] hover:text-[#F00000]' }}">
                    
                    {{ $link['name'] }}
                    <span class="absolute bottom-0 left-0 w-full h-[3px] bg-[#F00000] transform {{ $link['active'] ? 'scale-x-100' : 'scale-x-0' }} group-hover:scale-x-100 transition-transform duration-300 ease-in-out origin-left"></span>
                </a>
            @endforeach

            @auth
                <form method="POST" action="{{ route('logout') }}" class="m-0 p-0 pl-4 border-l-2 border-gray-200">
                    @csrf
                    <button type="submit" class="relative py-2 transition-colors duration-300 group font-bold text-[#000000] hover:text-[#F00000] uppercase tracking-wider">
                        Salir
                        <span class="absolute bottom-0 left-0 w-full h-[3px] bg-[#F00000] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-in-out origin-left"></span>
                    </button>
                </form>
            @endauth
        </nav>

        {{-- Botón hamburgesa --}}
        <div class="!flex md:!hidden items-center z-50">
            <button @click="open = !open" class="text-[#000000] hover:text-[#F00000] focus:outline-none transition-colors mt-1">
                <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    {{-- Usamos x-show de Alpine en lugar de clases de Tailwind para evitar conflictos --}}
                    <path x-show="!open" stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open" stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;" />
                </svg>
            </button>
        </div>
    </div>

    {{-- Menú desplegable --}}
    <div x-show="open" 
         style="display: none;"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="md:hidden absolute top-full left-0 w-full bg-white border-b-4 border-[#F00000] shadow-xl z-40">
        
        <div class="flex flex-col px-8 py-6 space-y-4">
            @foreach($links as $link)
                <a href="{{ $link['url'] }}" 
                   wire:navigate
                   @click="open = false"
                   wire:key="nav-link-mobile-{{ Str::slug($link['name']) }}"
                   class="text-xl font-bold uppercase tracking-widest border-l-4 pl-4 transition-colors {{ $link['active'] ? 'text-[#F00000] border-[#F00000] bg-[#FFE5E5] py-2' : 'text-[#000000] border-transparent hover:border-[#000000]' }}">
                    {{ $link['name'] }}
                </a>
            @endforeach

            @auth
                <form method="POST" action="{{ route('logout') }}" class="m-0 p-0 mt-4 pt-6 border-t border-gray-200">
                    @csrf
                    <button type="submit" class="w-full text-left font-bold uppercase tracking-widest text-[#000000] hover:text-[#F00000] text-xl">
                        Cerrar Sesión
                    </button>
                </form>
            @endauth
        </div>
    </div>
</header>