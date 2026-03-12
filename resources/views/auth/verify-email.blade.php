@extends('layouts.app')

@section('content')

<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-[#000000]">
            Verifica tu <span class="text-[#F00000]">correo</span>
        </h2>
        <p class="text-gray-600 mt-4 text-sm leading-relaxed">
            ¡Gracias por unirte a Clab! Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar? Si no lo recibiste, con gusto te enviaremos otro.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 text-[#F00000] font-bold text-center bg-[#FFE5E5] p-4 border border-[#F00000]">
            Un nuevo enlace de verificación ha sido enviado a la dirección de correo electrónico que proporcionaste durante el registro.
        </div>
    @endif

    <div class="mt-8 flex flex-col items-center justify-center space-y-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf
            <button type="submit" class="w-full bg-[#000000] text-white font-bold py-4 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm">
                Reenviar correo
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-600 hover:text-[#F00000] transition underline underline-offset-4 font-bold">
                Cerrar sesión
            </button>
        </form>
    </div>
</x-guest-layout>

@endsection
