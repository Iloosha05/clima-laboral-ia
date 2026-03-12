@extends('layouts.app')

@section('content')

<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-[#000000]">
            Confirma tu <span class="text-[#F00000]">identidad</span>
        </h2>
        <p class="text-gray-600 mt-4 text-sm leading-relaxed">
            Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <div>
            <label for="password" class="block text-sm font-bold text-[#000000] uppercase tracking-wider mb-1">
                Contraseña
            </label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="current-password"
                   class="block w-full border-[#000000] focus:border-[#F00000] focus:ring-[#F00000] py-3 px-4 transition duration-300"
                   placeholder="••••••••">
            
            @if($errors->has('password'))
                <p class="text-[#F00000] text-xs mt-1 font-medium">{{ $errors->first('password') }}</p>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-[#000000] text-white font-bold py-4 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm">
                Confirmar
            </button>
        </div>
    </form>
</x-guest-layout>

@endsection
