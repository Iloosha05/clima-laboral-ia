@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-8 py-12">   
    {{-- El titulo y boton para qrear una encuesta --}}
    <div class="flex justify-between items-end mb-10">
        <div>
            <h1 class="text-4xl font-bold text-[#000000] tracking-tight">
                Panel de <span class="text-[#F00000]">RRHH</span>
            </h1>
            <p class="text-gray-600 mt-2">Gestiona las encuestas de clima laboral de tu equipo.</p>
        </div>
        <a href="{{ route('hr.surveys.create') }}" class="bg-[#000000] text-white font-bold py-3 px-6 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm flex items-center gap-2 shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Nueva Encuesta
        </a>
    </div>

    {{-- Lista de encuestas --}}
    <div class="bg-white shadow-xl border-t-4 border-[#F00000] p-8">
        <h2 class="text-2xl font-bold text-[#000000] mb-6">Tus encuestas</h2>
        @if($surveys->isEmpty())
            <div class="text-center py-10 bg-[#FFE5E5] border border-[#F00000]">
                <p class="text-[#F00000] font-bold">Aun no has creado ninguna encuesta.</p>
                <p class="text-sm text-gray-700 mt-1">Haz clic en el botón superior para empezar.</p>
            </div>
        @else
            <div class="space-y-4">
                 @foreach($surveys as $survey)
                    <div class="flex justify-between items-center border border-gray-200 p-5 hover:border-[#000000] transition group">
                        <div>
                            <h3 class="text-lg font-bold text-[#000000] group-hover:text-[#F00000] transition">
                                {{ $survey->title }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Creada: {{ $survey->created_at->format('d/m/Y') }} 
                                @if($survey->deadline)
                                    | Límite: {{ $survey->deadline->format('d/m/Y') }}
                                @endif
                            </p>
                        </div>
                        <div class="flex items-center gap-6">
                            <span class="text-xs font-bold uppercase tracking-wider {{ $survey->is_active ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $survey->is_active ? 'Activa' : 'Cerrada' }}
                            </span> 
                            <a href="#" class="text-sm font-bold text-[#000000] hover:text-[#F00000] transition underline underline-offset-4">
                                Ver resultados
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
