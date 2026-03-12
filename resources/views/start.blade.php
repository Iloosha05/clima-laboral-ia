@extends('layouts.app')

@section('content')
{{-- Contenedor principal --}}
<div class="bg-[#FFE5E5] min-w-1200 min-h-[calc(100vh-160px)] flex items-center justify-center py-12 px-4">
    
    {{-- Tarjeta blanca --}}
    <div class="bg-white w-full max-w-6xl shadow-lg flex flex-col md:flex-row overflow-hidden">
        
        {{-- La parte de izquierda --}}
        <div class="w-full md:w-1/2 p-10 md:p-16 flex flex-col justify-center">
            
            <h1 class="text-3xl md:text-4xl font-bold text-[#000000] mb-6">
                ¡Bienvenidos a <span class="text-[#F00000]">Clab</span>!
            </h1>
            
            <p class="text-[#000000] mb-4 text-lg leading-relaxed">
                Una solución inteligente para analizar el clima laboral y fortalecer el trabajo en equipo.
            </p>
            
            <p class="text-[#000000] mb-10 text-lg leading-relaxed">
                A través de encuestas y datos, Clab ayuda a comprender mejor las necesidades de los empleados.
            </p>

            <h2 class="text-[#F00000] font-bold text-xl mb-6">
                ¡Empieza ahora mismo!
            </h2>

            <div class="flex gap-4">
                {{-- Botón Login --}}
                <a href="{{ route('login') }}" class="bg-white text-[#000000] border border-[#000000] px-8 py-3 font-medium hover:bg-black transition text-center hover:text-white min-w-[120px]">
                    Login
                </a>
                
                {{-- Botón Registro --}}
                <a href="{{ route('register') }}" class="bg-white text-[#000000] border border-[#000000] px-8 py-3 font-medium hover:bg-black transition text-center hover:text-white min-w-[120px]">
                    Registro
                </a>
            </div>
        </div>

        {{-- Imagen --}}
        <div class="w-full md:w-1/2 relative h-64 md:h-auto">
            <img 
                src="/images/main-image.jpg" 
                alt="Imagen principal" 
                class="absolute inset-0 w-full h-full object-cover"
            >
        </div>

    </div>
</div>

@endsection
