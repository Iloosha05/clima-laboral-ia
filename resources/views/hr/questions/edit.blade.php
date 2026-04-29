@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex flex-col lg:flex-row gap-10">   
    
    {{-- Parte izquierda --}}
    <div class="w-full lg:w-1/3 lg:sticky lg:top-8 self-start">
        
        {{-- Botón volver --}}
        <a href="{{ route('hr.questions.create', $question->survey_id) }}" class="text-gray-500 hover:text-[#F00000] transition flex items-center gap-2 font-bold uppercase tracking-wider text-xs mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Volver a añadir preguntas
        </a>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#000000] tracking-tight mb-2">Editar <span class="text-[#F00000]">Pregunta</span></h1>
            <p class="text-gray-600 text-sm">Estás editando una pregunta de: <strong>{{ $question->survey->title }}</strong></p>
        </div>

        <form action="{{ route('hr.questions.update', $question) }}" method="POST" class="bg-white p-6 shadow-md border-t-4 border-[#F00000] space-y-6">
            @csrf
            @method('PUT')

            {{-- Pregunta --}}
            <div>
                <label for="text" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Pregunta</label>
                <textarea name="text" id="text" rows="3" required
                          class="w-full p-3 border border-gray-300 focus:border-[#F00000] focus:ring-0 focus:outline-none rounded-none shadow-sm transition-colors"
                          placeholder="Ej. ¿Cómo calificarías tu entorno de trabajo?">{{ old('text', $question->question_text) }}</textarea>
                @error('text') <p class="text-[#F00000] text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tipo de respuesta --}}
            <div>
                <label for="type" class="block text-sm font-bold text-[#000000] uppercase tracking-wide mb-2">Tipo de Respuesta</label>
                <select name="type" id="type" required
                        class="w-full p-3 border border-gray-300 focus:border-[#F00000] focus:ring-0 focus:outline-none rounded-none shadow-sm transition-colors bg-white">
                    <option value="text" {{ old('type', $question->type) == 'text' ? 'selected' : '' }}>Texto Corto</option>
                    <option value="textarea" {{ old('type', $question->type) == 'textarea' ? 'selected' : '' }}>Párrafo (Texto largo)</option>
                    <option value="scale" {{ old('type', $question->type) == 'scale' ? 'selected' : '' }}>Escala (1 a 5)</option>
                    <option value="boolean" {{ old('type', $question->type) == 'boolean' ? 'selected' : '' }}>Sí / No</option>
                </select>
                @error('type') <p class="text-[#F00000] text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Obligatoria --}}
            <div class="flex items-center gap-2 pt-2">
                <input type="hidden" name="is_required" value="0">
                <input type="checkbox" name="is_required" id="is_required" value="1" {{ old('is_required', $question->is_required) ? 'checked' : '' }}
                       class="w-5 h-5 text-[#F00000] border-gray-300 focus:ring-[#F00000] rounded-none cursor-pointer">
                <label for="is_required" class="text-sm font-bold text-[#000000] cursor-pointer">¿Es obligatoria?</label>
            </div>

            <button type="submit" class="w-full bg-[#000000] text-white font-bold py-3 px-4 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-sm flex justify-center items-center gap-2 mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                </svg>
                Guardar Cambios
            </button>
        </form>
    </div>

    {{-- Parte derecha --}}
    <div class="w-full lg:w-2/3">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-[#000000]">Preguntas Añadidas <span class="text-gray-400 text-lg">({{ $question->survey->questions->count() }})</span></h2>
        </div>

        <div class="space-y-4">
            @php
                $typeLabels = [
                    'text' => 'Texto Corto',
                    'textarea' => 'Párrafo',
                    'scale' => 'Escala (1-5)',
                    'boolean' => 'Sí / No'
                ];
            @endphp

            @foreach($question->survey->questions as $index => $q)
                <div class="bg-white p-6 shadow-sm border-l-4 {{ $q->id == $question->id ? 'border-[#F00000]' : 'border-[#000000]' }} flex flex-col group hover:shadow-md transition-shadow">
                    <div class="flex gap-4">
                        <span class="text-2xl font-bold text-gray-300">{{ $index + 1 }}.</span>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-[#000000]">{{ $q->question_text }}</h3>
                            
                            <div class="flex justify-between items-center mt-3 pt-3 border-t border-gray-100">
                                <div class="flex items-center gap-4">
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 text-xs font-bold uppercase tracking-wider">
                                        {{ $typeLabels[$q->type] ?? 'Desconocido' }}
                                    </span>
                                    
                                    @if($q->is_required)
                                        <span class="text-[#F00000] text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Obligatoria
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection