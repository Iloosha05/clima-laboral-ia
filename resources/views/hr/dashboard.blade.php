@extends('layouts.app')

@section('content')
{{-- Contenedor principal --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    {{-- Encabezado --}}
    <div class="flex justify-between items-end mb-12 border-b-2 border-[#000000] pb-6">
        <div>
            <h1 class="text-4xl font-bold text-[#000000] tracking-tight">
                Panel de <span class="text-[#F00000]">Recursos Humanos</span>
            </h1>
            <p class="text-gray-600 mt-3 text-lg">Gestiona las encuestas de clima laboral de la empresa.</p>
        </div>
        
        {{-- Botón de acción --}}
        <a href="{{ route('hr.surveys.create') }}" 
           class="bg-[#000000] text-white font-bold py-4 px-8 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm shadow-md rounded-none">
            + Nueva Encuesta
        </a>
    </div>

    {{-- Cuadrícula de encuestas --}}
    @if($surveys->isEmpty())
        <div class="bg-white p-10 border-l-4 border-[#000000] shadow-md">
            <p class="text-gray-600 font-medium">Aun no has creado ninguna encuesta.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($surveys as $survey)
                <div class="bg-white border-t-4 border-[#000000] shadow-lg p-8 flex flex-col justify-between hover:shadow-2xl transition-shadow duration-300 relative group">
                    
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <h2 class="text-2xl font-bold text-[#000000] leading-tight group-hover:text-[#F00000] transition-colors uppercase tracking-tighter">
                                {{ $survey->title }}
                            </h2>
                            <span class="bg-gray-100 text-gray-800 text-[10px] font-black px-2 py-1 uppercase tracking-tighter border border-gray-200">
                                {{ $survey->is_active ? 'Activa' : 'Cerrada' }}
                            </span>
                        </div>
                        
                        <p class="text-gray-600 text-sm line-clamp-3 mb-6">
                            {{ $survey->description ?? 'Sin descripción disponible.' }}
                        </p>

                        <div class="space-y-2 mb-6">
                            <div class="flex items-center text-xs font-bold text-gray-400 uppercase tracking-widest">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Creada: {{ $survey->created_at->format('d/m/Y') }}
                            </div>
                            @if($survey->deadline)
                                <div class="flex items-center text-xs font-bold text-[#F00000] uppercase tracking-widest">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Límite: {{ \Carbon\Carbon::parse($survey->deadline)->format('d/m/Y') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Acciones con iconos --}}
                    <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                        <div class="flex gap-6">
                            {{-- Resultados --}}
                            <a href="{{ route('hr.surveys.results', $survey->id) }}" 
                               class="text-[#000000] hover:text-[#F00000] text-xs font-bold uppercase tracking-wider flex items-center gap-1.5 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Resultados
                            </a>

                            {{-- Editar --}}
                            <a href="{{ route('hr.surveys.edit', $survey->id) }}" 
                               class="text-[#000000] hover:text-[#F00000] text-xs font-bold uppercase tracking-wider flex items-center gap-1.5 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Editar
                            </a>
                        </div>

                        {{-- Eliminar --}}
                        <form action="{{ route('hr.surveys.destroy', $survey->id) }}" method="POST" class="m-0 p-0"
                              onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta encuesta?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[#F00000] text-xs font-bold uppercase tracking-wider flex items-center gap-1.5 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection