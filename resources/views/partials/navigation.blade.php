<header class="site-header" x-data="{ mobileMenu: false }">
    <div class="site-title">Clima Laboral</div>

    <nav class="main-nav">
        <a href="{{ url('/') }}">Inicio</a>

        @auth
            @if(auth()->user()->role === 'hr')
                <a href="{{ route('hr.dashboard') }}">Dashboard HR</a>
            @endif

            <a href="{{ route('mood.create') }}">Encuesta</a>
            <a href="{{ route('profile.edit') }}">Perfil</a>

            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-button">Salir</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Registro</a>
        @endauth
    </nav>

    <button class="mobile-toggle" @click="mobileMenu = !mobileMenu">☰</button>

    <div class="mobile-menu" x-show="mobileMenu" x-transition>
        <a href="{{ url('/') }}">Inicio</a>

        @auth
            @if(auth()->user()->role === 'hr')
                <a href="{{ route('hr.dashboard') }}">Dashboard HR</a>
            @endif
            <a href="{{ route('mood.create') }}">Encuesta</a>
            <a href="{{ route('profile.edit') }}">Perfil</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">Salir</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Registro</a>
        @endauth
    </div>
</header>
