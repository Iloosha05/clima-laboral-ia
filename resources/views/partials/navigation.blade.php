<header class="bg-white py-4 px-8 shadow-sm">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        {{-- Logo --}}
        <div class="flex items-end text-3xl font-bold tracking-tighter">    
            <a href="{{ url('/') }}" wire:navigate class="leading-none">
                <img src="/images/logo1.svg" alt="Logo" class="h-8 block">
            </a>
            <img src="/images/logo2.svg" alt="Logo2" class="h-4 ml-1 mb-[2px]"> 
        </div>

        {{-- Nav --}}
        <nav class="flex gap-8 text-lg font-medium items-center">
            @php
                $links = [
                    ['name' => 'Inicio', 'url' => url('/'), 'active' => request()->is('/')]
                ];

                // Mirar el status de usuario
                if (Auth::check()) {
                    $dashRoute = Auth::user()->role === 'hr' ? route('hr.dashboard') : route('dashboard');
                    $links[] = [
                        'name' => 'Dashboard', 
                        'url' => $dashRoute, 
                        'active' => request()->routeIs('dashboard') || request()->routeIs('hr.dashboard')
                    ];
                } else {
                    // Enlaces para guests
                    $links[] = ['name' => 'Login', 'url' => route('login'), 'active' => request()->routeIs('login')];
                    $links[] = ['name' => 'Registro', 'url' => route('register'), 'active' => request()->routeIs('register')];
                }
            @endphp

            @foreach($links as $link)
                <a href="{{ $link['url'] }}" 
                   wire:navigate
                   wire:key="nav-link-{{ Str::slug($link['name']) }}"
                   class="relative py-2 transition-colors duration-300 group {{ $link['active'] ? 'text-[#F00000]' : 'text-[#000000] hover:text-[#F00000]' }}">
                    
                    {{ $link['name'] }}

                    {{-- Subroyamos el texto --}}
                    <span class="absolute bottom-0 left-0 w-full h-[2px] bg-[#F00000] transform 
                        {{ $link['active'] ? 'scale-x-100' : 'scale-x-0' }} 
                        group-hover:scale-x-100 transition-transform duration-300 ease-in-out origin-left">
                    </span>
                </a>
            @endforeach

            {{-- Boton -para salir --}}
            @auth
                <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="relative py-2 transition-colors duration-300 group text-[#000000] hover:text-[#F00000]">
                        Salir
                        <span class="absolute bottom-0 left-0 w-full h-[2px] bg-[#F00000] transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-in-out origin-left"></span>
                    </button>
                </form>
            @endauth
        </nav>
    </div>
</header>