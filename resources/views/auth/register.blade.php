@extends('layouts.app')

@section('content')

<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-[#000000]">
            Crea tu <span class="text-[#F00000]">cuenta</span>
        </h2>
        <p class="text-gray-600 mt-2">Únete a Clab y mejora tu entorno laboral</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-sm font-bold text-[#000000] uppercase tracking-wider mb-1">
                {{ __('Name') }}
            </label>
            <input id="name" 
                   type="text" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus 
                   class="block w-full border-[#000000] focus:border-[#F00000] focus:ring-[#F00000] py-3 px-4 transition duration-300"
                   placeholder="Tu nombre completo">
            @if($errors->has('name'))
                <p class="text-[#F00000] text-xs mt-1 font-medium">{{ $errors->first('name') }}</p>
            @endif
        </div>

        <div>
            <label for="email" class="block text-sm font-bold text-[#000000] uppercase tracking-wider mb-1">
                {{ __('Email') }}
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   class="block w-full border-[#000000] focus:border-[#F00000] focus:ring-[#F00000] py-3 px-4 transition duration-300"
                   placeholder="tu@email.com">
            @if($errors->has('email'))
                <p class="text-[#F00000] text-xs mt-1 font-medium">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div>
            <label for="password" class="block text-sm font-bold text-[#000000] uppercase tracking-wider mb-1">
                {{ __('Password') }}
            </label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   class="block w-full border-[#000000] focus:border-[#F00000] focus:ring-[#F00000] py-3 px-4 transition duration-300"
                   placeholder="••••••••">
            @if($errors->has('password'))
                <p class="text-[#F00000] text-xs mt-1 font-medium">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-[#000000] uppercase tracking-wider mb-1">
                {{ __('Confirm Password') }}
            </label>
            <input id="password_confirmation" 
                   type="password" 
                   name="password_confirmation" 
                   required 
                   class="block w-full border-[#000000] focus:border-[#F00000] focus:ring-[#F00000] py-3 px-4 transition duration-300"
                   placeholder="••••••••">
            @if($errors->has('password_confirmation'))
                <p class="text-[#F00000] text-xs mt-1 font-medium">{{ $errors->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="pt-4 space-y-4">
            <button type="submit" class="w-full bg-[#000000] text-white font-bold py-4 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm">
                {{ __('Register') }}
            </button>

            <p class="text-center text-sm text-gray-600">
                {{ __('Already registered?') }} 
                <a href="{{ route('login') }}" class="text-[#F00000] font-bold hover:underline ml-1">
                    Inicia sesión
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>

@endsection
