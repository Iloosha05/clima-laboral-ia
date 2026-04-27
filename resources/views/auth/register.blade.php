@extends('layouts.app')

@section('content')

<x-guest-layout>
    {{-- Contenedor principal de la tarjeta de registro --}}
    <div class="bg-white shadow-xl border-t-4 border-[#F00000] p-8 max-w-md mx-auto mt-10">
        
        {{-- Encabezado --}}
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-bold text-[#000000] uppercase tracking-tight">
                Crear <span class="text-[#F00000]">Cuenta</span>
            </h2>
            <p class="text-gray-500 text-sm mt-2 font-medium">Únete a nuestra plataforma</p>
        </div>

        {{-- Formulario --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            {{-- Campo: Nombre Completo --}}
            <div>
                <label for="name" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Nombre Completo</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                       class="w-full border-gray-300 focus:border-[#F00000] focus:ring-[#F00000] rounded-none shadow-sm">
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-[#F00000] text-xs font-bold" />
            </div>

            {{-- Campo: Correo Electrónico --}}
            <div>
                <label for="email" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                       class="w-full border-gray-300 focus:border-[#F00000] focus:ring-[#F00000] rounded-none shadow-sm">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-[#F00000] text-xs font-bold" />
            </div>

            {{-- Campo: Contraseña --}}
            <div>
                <label for="password" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="w-full border-gray-300 focus:border-[#F00000] focus:ring-[#F00000] rounded-none shadow-sm">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-[#F00000] text-xs font-bold" />
            </div>

            {{-- Campo: Confirmar Contraseña --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Confirmar Contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="w-full border-gray-300 focus:border-[#F00000] focus:ring-[#F00000] rounded-none shadow-sm">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-[#F00000] text-xs font-bold" />
            </div>

            {{-- Botón de Registro --}}
            <div class="pt-4 mt-6 border-t border-gray-100">
                <button type="submit" class="w-full bg-[#000000] text-white font-bold py-3 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm shadow-md rounded-none">
                    Registrarse
                </button>
            </div>

            {{-- Enlace a Login --}}
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-[#F00000] font-bold transition underline underline-offset-2">
                    ¿Ya estás registrado? Inicia sesión
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>

@endsection
