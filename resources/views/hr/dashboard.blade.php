@extends('layouts.app')

@section('content')
{{-- Contenedor principal --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    {{-- Encabezado --}}
    <div class="flex justify-between items-end mb-10 border-b-2 border-[#000000] pb-4">
        <div>
            <h1 class="text-4xl font-bold text-[#000000] tracking-tight">
                Panel de <span class="text-[#F00000]">Recursos Humanos</span>
            </h1>
            <p class="text-gray-600 mt-2">Gestiona las encuestas de clima laboral de la empresa.</p>
        </div>
        
        {{-- Botón de acción --}}
        <a href="{{ route('hr.surveys.create') }}" 
           class="bg-[#000000] text-white font-bold py-3 px-6 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm shadow-md rounded-none">
            + Nueva Encuesta
        </a>
    </div>

    {{-- Cuadrícula de encuestas --}}
    @if($surveys->isEmpty())
        <div class="bg-white p-8 border-l-4 border-[#000000] shadow-md">
            <p class="text-gray-600 font-medium">Aun no has creado ninguna encuesta.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($surveys as $survey)
                <div class="bg-white flex flex-col h-full shadow-md border-t-4 border-[#000000] hover:shadow-xl transition-shadow duration-300">
                    
                    {{-- Contenido principal de la tarjeta --}}
                    <div class="p-6 flex-grow">
                        <div class="flex justify-between items-start mb-4">
                            @if($survey->is_active)
                                <span class="bg-[#FFE5E5] text-[#F00000] text-xs font-bold px-3 py-1 uppercase tracking-wider">Activa</span>
                            @else
                                <span class="bg-gray-100 text-gray-500 text-xs font-bold px-3 py-1 uppercase tracking-wider">Cerrada</span>
                            @endif
                            
                            <span class="text-xs text-gray-500 font-bold">{{ $survey->created_at->format('d/m/Y') }}</span>
                        </div>
                        
                        <h2 class="text-2xl font-bold text-[#000000] mb-3">{{ $survey->title }}</h2>
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                            {{ $survey->description ?? 'Sin descripción.' }}
                        </p>
                    </div>
                    
                    {{-- Acciones de la tarjeta --}}
                    <div class="p-6 pt-0 mt-auto flex flex-col gap-3">
                        <a href="{{ route('hr.questions.create', $survey) }}" 
                           class="block w-full text-center border-2 border-[#000000] text-[#000000] font-bold py-2 hover:bg-[#000000] hover:text-white transition duration-300 uppercase tracking-widest text-xs">
                            Gestionar Preguntas
                        </a>
                        
                        <a href="{{ route('hr.surveys.results', $survey->id) }}" class="block w-full text-center bg-gray-100 text-[#000000] hover:bg-[#000000] hover:text-white font-bold py-2 uppercase tracking-widest text-xs transition duration-300">
                            Ver Resultados
                        </a>

                        {{-- Botón de eliminar --}}
                        <form action="{{ route('hr.surveys.destroy', $survey->id) }}" method="POST" class="w-full"
                              onsubmit="return confirm('¿Estás seguro de que deseas eliminar la encuesta \'{{ addslashes($survey->title) }}\'? Esta acción borrará también todas las respuestas y no se puede deshacer.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full text-center border-2 border-[#F00000] text-[#F00000] font-bold py-2 hover:bg-[#F00000] hover:text-white transition duration-300 uppercase tracking-widest text-xs flex justify-center items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Eliminar Encuesta
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection