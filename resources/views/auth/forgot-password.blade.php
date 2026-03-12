@extends('layouts.app')

@section('content')

<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-[#000000]">
            Recupera tu <span class="text-[#F00000]">acceso</span>
        </h2>
        <p class="text-gray-600 mt-4 text-sm leading-relaxed">
            ¿Olvidaste tu contraseña? No hay problema. Ingresa tu correo electrónico y te enviaremos un enlace para que puedas crear una nueva.
        </p>
    </div>

    <x-auth-session-status class="mb-6 text-[#F00000] font-bold text-center bg-[#FFE5E5] p-3 border border-[#F00000]" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-bold text-[#000000] uppercase tracking-wider mb-1">
                {{ __('Email') }}
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   class="block w-full border-[#000000] focus:border-[#F00000] focus:ring-[#F00000] py-3 px-4 transition duration-300"
                   placeholder="tu@email.com">
            
            @if($errors->has('email'))
                <p class="text-[#F00000] text-xs mt-1 font-medium">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div class="pt-2 space-y-4">
            <button type="submit" class="w-full bg-[#000000] text-white font-bold py-4 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm">
                Enviar enlace de recuperación
            </button>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-[#F00000] transition underline underline-offset-4 font-bold">
                    Volver al inicio de sesión
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>

@endsection
