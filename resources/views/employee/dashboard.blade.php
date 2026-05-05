@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">   
    
    {{-- Encabezado del empleado --}}
    <div class="mb-12 border-b-2 border-[#000000] pb-6">
        <h1 class="text-4xl font-bold text-[#000000] tracking-tight">
            Hola, <span class="text-[#F00000]">{{ Auth::user()->name ?? 'Empleado' }}</span>
        </h1>
        <p class="text-gray-600 mt-3 text-lg">Tu opinión es fundamental. Las siguientes encuestas son 100% anónimas.</p>
    </div>

    <h3 class="text-xl font-bold text-[#000000] uppercase tracking-wider mb-8">
        Encuestas Pendientes
    </h3>

    {{-- Cuadrícula de encuestas --}}
    @if($surveys->isEmpty())
        <div class="bg-white border-l-4 border-[#000000] p-10 shadow-md">
            <p class="text-gray-600 font-medium text-lg">No tienes encuestas pendientes en este momento. ¡Buen trabajo!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($surveys as $survey)
                {{-- Tarjeta --}}
                <div class="bg-white shadow-lg border-t-4 border-[#000000] p-8 flex flex-col justify-between hover:shadow-2xl transition-shadow duration-300 group">
                    
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="flex items-center gap-1 text-[10px] font-semibold px-2 py-1 uppercase tracking-tighter bg-[#FFE5E5] text-[#F00000] border border-[#F00000]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.379-8.379-2.828-2.828z" />
                                </svg>
                                Pendiente
                            </span>
                            
                            @if($survey->deadline)
                                <span class="flex items-center gap-1 text-[10px] font-semibold px-2 py-1 uppercase tracking-tighter bg-gray-100 text-gray-500 border border-gray-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Vence: {{ \Carbon\Carbon::parse($survey->deadline)->format('d/m/Y') }}
                                </span>
                            @endif
                        </div>
                        
                        <h4 class="text-2xl font-bold text-[#000000] mb-4 group-hover:text-[#F00000] transition-colors uppercase tracking-tighter leading-tight">
                            {{ $survey->title }}
                        </h4>
                        
                        <p class="text-gray-600 text-sm line-clamp-3">
                            {{ $survey->description ?? 'Ayudanos a mejorar el clima laboral completando esta breve encuesta.' }}
                        </p>
                    </div>
                    
                    {{-- Botón de Acción --}}
                    <div class="pt-6 border-t border-gray-100">
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