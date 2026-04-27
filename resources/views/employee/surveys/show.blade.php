@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    {{-- Botón Volver --}}
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-[#F00000] transition flex items-center gap-2 font-bold uppercase tracking-wider text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Volver al Inicio
        </a>
    </div>

    {{-- Alertas de errores de servidor --}}
    @if(session('error'))
        <div class="bg-[#FFE5E5] border-l-4 border-[#F00000] p-4 mb-6 shadow-sm">
            <p class="text-[#F00000] font-bold flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ session('error') }}
            </p>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-[#FFE5E5] border-l-4 border-[#F00000] p-4 mb-6 shadow-sm">
            <p class="text-[#F00000] font-bold">{{ $errors->first() }}</p>
        </div>
    @endif

    {{-- Encabezado de la encuesta --}}
    <div class="bg-white p-8 shadow-md border-b-4 border-[#F00000] mb-8">
        <h1 class="text-3xl font-bold text-[#000000] mb-3">{{ $survey->title }}</h1>
        @if($survey->description)
            <p class="text-gray-600 text-lg">{{ $survey->description }}</p>
        @endif
        <p class="text-sm text-gray-400 mt-4 font-bold uppercase tracking-widest">
            Por favor, responde con sinceridad. Tus respuestas son anónimas.
        </p>
    </div>

    {{-- Formulario de respuestas --}}
    <form action="{{ route('employee.surveys.store', $survey) }}" method="POST" class="space-y-8">
        @csrf

        @foreach($survey->questions as $index => $question)
            <div class="bg-white p-8 shadow-sm border-t-4 border-[#000000]">
                
                {{-- Título de la pregunta --}}
                <h3 class="text-xl font-bold text-[#000000] mb-6 flex gap-2">
                    <span class="text-gray-300">{{ $index + 1 }}.</span> 
                    {{ $question->question_text }}
                    @if($question->is_required)
                        <span class="text-[#F00000] text-2xl leading-none" title="Pregunta Obligatoria">*</span>
                    @endif
                </h3>

                {{-- Renderizado --}}
                <div class="pl-8">
                    
                    @if($question->type === 'text')
                        <input type="text" name="answers[{{ $question->id }}]" 
                               value="{{ old('answers.'.$question->id) }}"
                               class="w-full p-4 border-2 border-gray-200 focus:border-[#F00000] focus:ring-0 focus:outline-none transition-colors rounded-none" 
                               placeholder="Escribe tu respuesta aquí...">

                    @elseif($question->type === 'textarea')
                        <textarea name="answers[{{ $question->id }}]" rows="4" 
                                  class="w-full p-4 border-2 border-gray-200 focus:border-[#F00000] focus:ring-0 focus:outline-none transition-colors rounded-none" 
                                  placeholder="Detalla tu respuesta aquí...">{{ old('answers.'.$question->id) }}</textarea>

                    @elseif($question->type === 'scale')
                        <div class="flex flex-wrap items-center gap-4 sm:gap-6">
                            <span class="text-sm font-bold text-gray-400 uppercase">Muy en desacuerdo</span>
                            
                            <div class="flex gap-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer group relative">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $i }}" class="sr-only peer" {{ old('answers.'.$question->id) == $i ? 'checked' : '' }}>
                                        <div class="w-12 h-12 flex items-center justify-center border-2 border-gray-300 rounded-full peer-checked:bg-[#F00000] peer-checked:border-[#F00000] peer-checked:text-white group-hover:border-[#000000] transition-all duration-200 text-lg font-bold text-gray-500 peer-checked:shadow-lg">
                                            {{ $i }}
                                        </div>
                                    </label>
                                @endfor
                            </div>
                            
                            <span class="text-sm font-bold text-gray-400 uppercase">Muy de acuerdo</span>
                        </div>

                    @elseif($question->type === 'boolean')
                        <div class="flex gap-8">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="answers[{{ $question->id }}]" value="Si" class="w-6 h-6 text-[#F00000] border-2 border-gray-300 focus:ring-[#F00000] rounded-none cursor-pointer" {{ old('answers.'.$question->id) == 'Si' ? 'checked' : '' }}>
                                <span class="text-lg font-bold text-gray-600 group-hover:text-[#000000] transition-colors">Sí</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="answers[{{ $question->id }}]" value="No" class="w-6 h-6 text-[#F00000] border-2 border-gray-300 focus:ring-[#F00000] rounded-none cursor-pointer" {{ old('answers.'.$question->id) == 'No' ? 'checked' : '' }}>
                                <span class="text-lg font-bold text-gray-600 group-hover:text-[#000000] transition-colors">No</span>
                            </label>
                        </div>
                    @endif

                </div>
            </div>
        @endforeach

        <div class="pt-6">
            <button type="submit" class="w-full md:w-auto bg-[#000000] text-white font-bold py-4 px-10 hover:bg-[#F00000] transition duration-300 uppercase tracking-widest text-lg shadow-xl flex justify-center items-center gap-3">
                Enviar Respuestas
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </form>
</div>
@endsection