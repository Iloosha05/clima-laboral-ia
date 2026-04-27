@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">   
    
    {{-- Encabezado del empleado --}}
    <div class="mb-10 border-b-2 border-gray-200 pb-6">
        <h1 class="text-4xl font-bold text-[#000000] tracking-tight">
            Hola, <span class="text-[#F00000]">{{ Auth::user()->name ?? 'Empleado' }}</span>
        </h1>
        <p class="text-gray-600 mt-3 text-lg">Tu opinión es fundamental. Las siguientes encuestas son 100% anónimas.</p>
    </div>

    <h3 class="text-xl font-bold text-[#000000] uppercase tracking-wider mb-6">
        Encuestas Pendientes
    </h3>

    {{-- Cuadrícula de encuestas --}}
    @if($surveys->isEmpty())
        <div class="bg-white border-l-4 border-gray-400 p-8 shadow-md">
            <p class="text-gray-600 font-medium text-lg">No tienes encuestas pendientes en este momento. ¡Buen trabajo!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($surveys as $survey)
                {{-- Tarjeta --}}
                <div class="bg-white shadow-xl border-t-4 border-[#F00000] flex flex-col h-full hover:shadow-2xl transition-shadow duration-300">
                    <div class="p-6 flex-grow">
                        <div class="flex justify-between items-start mb-4">
                            <span class="text-xs font-bold text-[#F00000] uppercase tracking-widest flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                Pendiente
                            </span>
                            
                            @if($survey->deadline)
                                <span class="text-xs text-gray-500 font-bold bg-gray-100 px-2 py-1">
                                    Vence: {{ $survey->deadline->format('d/m/Y') }}
                                </span>
                            @endif
                        </div>
                        
                        <h4 class="text-2xl font-bold text-[#000000] mb-3">{{ $survey->title }}</h4>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ $survey->description ?? 'Ayúdanos a mejorar el clima laboral completando esta breve encuesta.' }}
                        </p>
                    </div>
                    
                    {{-- Botón de Acción --}}
                    <div class="p-6 pt-0 mt-auto">
                        <a href="{{ route('employee.surveys.show', $survey) }}" 
                           class="block w-full text-center bg-[#000000] text-white font-bold py-4 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm shadow-md rounded-none">
                            Realizar Encuesta
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection