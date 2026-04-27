@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-8 py-12">   
    
    <div class="mb-6">
        <a href="{{ route('hr.dashboard') }}" class="text-gray-500 hover:text-[#F00000] transition flex items-center gap-2 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Volver al Panel
        </a>
    </div>

    <div class="mb-10">
        <h1 class="text-4xl font-bold text-[#000000] tracking-tight">Crear Nueva <span class="text-[#F00000]">Encuesta</span></h1>
        <p class="text-gray-600 mt-2">Configura los detalles básicos antes de añadir las preguntas.</p>
    </div>

    <form action="{{ route('hr.surveys.store') }}" method="POST" class="bg-white p-8 shadow-md border-t-4 border-[#000000] space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Título de la Encuesta</label>
            <input type="text" name="title" id="title" required 
                   value="{{ old('title') }}"
                   class="w-full p-3 border border-gray-300 focus:border-[#F00000] focus:ring-0 focus:outline-none rounded-none shadow-sm transition-colors"
                   placeholder="Ej. Clima Laboral - Q3 2026">
            @error('title') <p class="text-[#F00000] text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Descripción (Opcional)</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full p-3 border border-gray-300 focus:border-[#F00000] focus:ring-0 focus:outline-none rounded-none shadow-sm transition-colors"
                      placeholder="Explica brevemente el propósito de esta encuesta...">{{ old('description') }}</textarea>
            @error('description') <p class="text-[#F00000] text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="deadline" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Fecha Límite (Opcional)</label>
            <input type="date" name="deadline" id="deadline"
                   value="{{ old('deadline') }}"
                   class="w-full md:w-1/3 p-3 border border-gray-300 focus:border-[#F00000] focus:ring-0 focus:outline-none rounded-none shadow-sm transition-colors">
            @error('deadline') <p class="text-[#F00000] text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-[#000000] text-white font-bold py-3 px-8 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm w-full md:w-auto">
                Continuar a Preguntas
            </button>
        </div>
    </form>
</div>
@endsection