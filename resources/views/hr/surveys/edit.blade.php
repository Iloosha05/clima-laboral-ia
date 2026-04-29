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
        <h1 class="text-4xl font-bold text-[#000000] tracking-tight">Editar <span class="text-[#F00000]">Encuesta</span></h1>
        <p class="text-gray-600 mt-2">Modifica los detalles generales de la encuesta.</p>
    </div>

    <div class="bg-white p-8 border-t-4 border-[#F00000] shadow-xl">
        <form action="{{ route('hr.surveys.update', $survey->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Título de la Encuesta</label>
                <input type="text" name="title" id="title" 
                       value="{{ old('title', $survey->title) }}" 
                       class="w-full p-3 border border-gray-300 focus:border-[#F00000] focus:ring-0 focus:outline-none rounded-none shadow-sm transition-colors"
                       required>
                @error('title') <p class="text-[#F00000] text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Descripción (Opcional)</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full p-3 border border-gray-300 focus:border-[#F00000] focus:ring-0 focus:outline-none rounded-none shadow-sm transition-colors">{{ old('description', $survey->description) }}</textarea>
                @error('description') <p class="text-[#F00000] text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="deadline" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Fecha Límite (Opcional)</label>
                <input type="date" name="deadline" id="deadline"
                       value="{{ old('deadline', $survey->deadline ? $survey->deadline->format('Y-m-d') : '') }}"
                       class="w-full md:w-1/3 p-3 border border-gray-300 focus:border-[#F00000] focus:ring-0 focus:outline-none rounded-none shadow-sm transition-colors">
                @error('deadline') <p class="text-[#F00000] text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 border-t border-gray-100 flex gap-4">
                <button type="submit" class="bg-[#000000] text-white font-bold py-3 px-8 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm shadow-md rounded-none">
                    Guardar Cambios
                </button>
                <a href="{{ route('hr.questions.create', $survey->id) }}" class="bg-gray-100 text-[#000000] font-bold py-3 px-8 hover:bg-gray-200 transition duration-300 uppercase tracking-widest text-sm rounded-none">
                    Gestionar Preguntas
                </a>
            </div>
        </form>
    </div>
</div>
@endsection