@extends('layouts.app')

@section('content')

<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-[#000000]">
            Nueva <span class="text-[#F00000]">contraseña</span>
        </h2>
        <p class="text-gray-600 mt-2 text-sm">
            Ingresa tu nueva contraseña para recuperar el acceso.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-sm font-bold text-[#000000] uppercase tracking-wider mb-1">
                {{ __('Email') }}
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email', $request->email) }}" 
                   required 
                   autofocus 
                   autocomplete="username"
                   class="block w-full border-[#000000] focus:border-[#F00000] focus:ring-[#F00000] py-3 px-4 transition duration-300"
                   placeholder="tu@email.com">
            
            @if($errors->has('email'))
                <p class="text-[#F00000] text-xs mt-1 font-medium">{{ $errors->first('email') }}</p>
            @endif
        </div>

        <div>
            <label for="password" class="block text-sm font-bold text-[#000000] uppercase tracking-wider mb-1">
                Nueva Contraseña
            </label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="new-password"
                   class="block w-full border-[#000000] focus:border-[#F00000] focus:ring-[#F00000] py-3 px-4 transition duration-300"
                   placeholder="••••••••">
            
            @if($errors->has('password'))
                <p class="text-[#F00000] text-xs mt-1 font-medium">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-[#000000] uppercase tracking-wider mb-1">
                Confirmar Contraseña
            </label>
            <input id="password_confirmation" 
                   type="password" 
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password"
                   class="block w-full border-[#000000] focus:border-[#F00000] focus:ring-[#F00000] py-3 px-4 transition duration-300"
                   placeholder="••••••••">
            
            @if($errors->has('password_confirmation'))
                <p class="text-[#F00000] text-xs mt-1 font-medium">{{ $errors->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-[#000000] text-white font-bold py-4 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm">
                Guardar y entrar
            </button>
        </div>
    </form>
</x-guest-layout>

@endsection
