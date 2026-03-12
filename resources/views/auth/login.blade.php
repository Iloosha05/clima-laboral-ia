@extends('layouts.app')

@section('content')

<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-[#000000]">
            ¡Hola de <span class="text-[#F00000]">nuevo</span>!
        </h2>
        <p class="text-gray-600 mt-2">Introduce tus datos para continuar</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
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
                   class="block w-full border-[#00000] focus:border-[#F00000] focus:ring-[#F00000] shadow-sm py-3 px-4 transition duration-300"
                   placeholder="tu@email.com">
            @if($errors->has('email'))
                <p class="text-[#F00000] text-xs mt-1 font-medium">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div>
            <div class="flex justify-between items-center mb-1">
                <label for="password" class="block text-sm font-bold text-[#000000] uppercase tracking-wider">
                    {{ __('Contraseña') }}
                </label>
            </div>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   class="block w-full border-[#000000] focus:border-[#F00000] focus:ring-[#F00000] shadow-sm py-3 px-4 transition duration-300"
                   placeholder="••••••••">
            @if($errors->has('password'))
                <p class="text-[#F00000] text-xs mt-1 font-medium">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="border-[#000000] text-[#000000] focus:ring-[#F00000] cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-gray-600 group-hover:text-[#000000] transition">{{ __('Recordarme') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 hover:text-[#F00000] transition underline underline-offset-4" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-[#000000] text-white font-bold py-4 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm">
                {{ __('Log in') }}
            </button>
        </div>
        
        <p class="text-center text-sm text-gray-600 mt-6">
            ¿No tienes cuenta? 
            <a href="{{ route('register') }}" class="text-[#F00000] font-bold hover:underline">Regístrate</a>
        </p>
    </form>
</x-guest-layout>

@endsection
