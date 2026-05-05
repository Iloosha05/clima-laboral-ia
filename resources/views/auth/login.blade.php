@extends('layouts.app')

@section('content')

<div class="min-h-[80vh] flex flex-col justify-center py-12 px-4">
    {{-- Contenedor principal de la tarjeta de login --}}
    <div class="w-full bg-white shadow-xl border-t-4 border-[#000000] p-8 max-w-md mx-auto">
        
        {{-- Encabezado --}}
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-[#000000] uppercase tracking-tight">
                Iniciar <span class="text-[#F00000]">Sesión</span>
            </h2>
            <p class="text-gray-500 text-sm mt-2 font-medium">Accede al sistema de Clima Laboral</p>
        </div>

        {{-- Estado de la sesión (mensajes de éxito) --}}
        <x-auth-session-status class="mb-4" :status="session('status')" />

        {{-- Formulario --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            {{-- Campo: Correo Electrónico --}}
            <div>
                <label for="email" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       class="w-full border-gray-300 focus:border-[#F00000] focus:ring-[#F00000] rounded-none shadow-sm py-3 px-4 transition duration-300">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-[#F00000] text-xs font-bold" />
            </div>

            {{-- Campo: Contraseña --}}
            <div>
                <label for="password" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="w-full border-gray-300 focus:border-[#F00000] focus:ring-[#F00000] rounded-none shadow-sm py-3 px-4 transition duration-300">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-[#F00000] text-xs font-bold" />
            </div>

            {{-- Opciones adicionales (Recordarme y Olvidé mi contraseña) --}}
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" name="remember" class="border-gray-300 text-[#F00000] focus:ring-[#F00000] rounded-sm shadow-sm">
                    <span class="ms-2 text-sm text-[#000000] font-bold">Recordarme</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-500 hover:text-[#F00000] transition underline underline-offset-2 font-bold" href="{{ route('password.request') }}">
                        ¿Olvidaste la contraseña?
                    </a>
                @endif
            </div>

            {{-- Botón de Enviar --}}
            <div class="pt-4">
                <button type="submit" class="w-full bg-[#000000] text-white font-bold py-3 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm shadow-md rounded-none">
                    Entrar al Sistema
                </button>
            </div>
            
            {{-- Enlace a Registro --}}
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">¿No tienes cuenta? 
                    <a href="{{ route('register') }}" class="text-[#000000] font-bold hover:text-[#F00000] transition underline">Regístrate aquí</a>
                </p>
            </div>
        </form>
    </div>
</div>

@endsection