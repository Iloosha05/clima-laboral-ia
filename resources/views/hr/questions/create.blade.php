@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex flex-col lg:flex-row gap-10">   
    
    {{-- Parte izquierda --}}
    <div class="w-full lg:w-1/3 lg:sticky lg:top-8 self-start">
        
        {{-- Botón volver --}}
        <a href="{{ route('hr.dashboard') }}" class="text-gray-500 hover:text-[#F00000] transition flex items-center gap-2 font-bold uppercase tracking-wider text-xs mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Volver al panel
        </a>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#000000] tracking-tight mb-2">Añadir <span class="text-[#F00000]">Preguntas</span></h1>
            <p class="text-gray-600 text-sm">Estás editando: <strong>{{ $survey->title }}</strong></p>
        </div>

        <form action="{{ route('hr.questions.store', $survey) }}" method="POST" class="bg-white p-6 shadow-md border-t-4 border-[#000000] space-y-6">
            @csrf

            {{-- Pregunta --}}
            <div>
                <label for="text" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Pregunta</label>
                <textarea name="text" id="text" rows="3" required
                          class="w-full p-3 border border-gray-300 focus:border-[#F00000] focus:ring-0 focus:outline-none rounded-none shadow-sm transition-colors"
                          placeholder="Ej. ¿Cómo calificarías tu entorno de trabajo?">{{ old('text') }}</textarea>
                @error('text') <p class="text-[#F00000] text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tipo de respuesta --}}
            <div>
                <label for="type" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Tipo de Respuesta</label>
                <select name="type" id="type" required
                        class="w-full p-3 border border-gray-300 focus:border-[#F00000] focus:ring-0 focus:outline-none rounded-none shadow-sm transition-colors bg-white">
                    <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Texto Corto</option>
                    <option value="textarea" {{ old('type') == 'textarea' ? 'selected' : '' }}>Párrafo (Texto largo)</option>
                    <option value="scale" {{ old('type') == 'scale' ? 'selected' : '' }}>Escala (1 a 5)</option>
                    <option value="boolean" {{ old('type') == 'boolean' ? 'selected' : '' }}>Sí / No</option>
                </select>
                @error('type') <p class="text-[#F00000] text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Obligatoria --}}
            <div class="flex items-center gap-2 pt-2">
                <input type="hidden" name="is_required" value="0">
                <input type="checkbox" name="is_required" id="is_required" value="1" checked
                       class="w-5 h-5 text-[#F00000] border-gray-300 focus:ring-[#F00000] rounded-none cursor-pointer">
                <label for="is_required" class="text-sm font-bold text-[#000000] cursor-pointer">¿Es obligatoria?</label>
            </div>

            <button type="submit" class="w-full bg-[#000000] text-white font-bold py-3 px-4 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm flex justify-center items-center gap-2 mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Añadir Pregunta
            </button>
        </form>
    </div>

    {{-- Parte derecha --}}
    <div class="w-full lg:w-2/3">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-[#000000]">Preguntas Añadidas <span class="text-gray-400 text-lg">({{ $survey->questions->count() }})</span></h2>
            
            @if($survey->questions->count() > 0)
                <a href="{{ route('hr.dashboard') }}" class="bg-[#F00000] text-white font-bold py-2 px-6 hover:bg-[#000000] transition duration-300 uppercase tracking-widest text-sm shadow-md rounded-none">
                    Finalizar Encuesta
                </a>
            @endif
        </div>

        @if($survey->questions->isEmpty())
            <div class="bg-white p-12 text-center border-2 border-dashed border-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <p class="text-gray-500 font-medium">No hay preguntas todavía. Utiliza el formulario de la izquierda para añadir la primera.</p>
            </div>
        @else
            <div class="space-y-4">
                @php
                    // Mapeo de tipos para mostrar etiquetas bonitas
                    $typeLabels = [
                        'text' => 'Texto Corto',
                        'textarea' => 'Párrafo',
                        'scale' => 'Escala (1-5)',
                        'boolean' => 'Sí / No'
                    ];
                @endphp

                @foreach($survey->questions as $index => $question)
                    <div class="bg-white p-6 shadow-sm border-l-4 border-[#000000] flex flex-col group hover:shadow-md transition-shadow">
                        <div class="flex gap-4">
                            <span class="text-2xl font-bold text-gray-300">{{ $index + 1 }}.</span>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-[#000000]">{{ $question->question_text }}</h3>
                                
                                <div class="flex items-center gap-4 mt-3 pt-3 border-t border-gray-100">
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 text-xs font-bold uppercase tracking-wider">
                                        {{ $typeLabels[$question->type] ?? 'Desconocido' }}
                                    </span>
                                    
                                    @if($question->is_required)
                                        <span class="text-[#F00000] text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Obligatoria
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                                            Opcional
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection