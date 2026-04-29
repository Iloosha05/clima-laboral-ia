@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    {{-- Indicador de progreso y título --}}
    <div class="mb-12">
        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-[#F00000] transition flex items-center gap-2 font-bold uppercase tracking-wider text-xs mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Abandonar encuesta
        </a>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b-2 border-[#000000] pb-6">
            <div class="max-w-2xl">
                <h1 class="text-4xl font-bold text-[#000000] tracking-tight uppercase leading-tight">
                    {{ $survey->title }}
                </h1>
                <p class="text-gray-600 mt-3 text-lg italic">
                    {{ $survey->description ?? 'Tu participación es anónima y voluntaria.' }}
                </p>
            </div>
            <div class="text-right">
                <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Total de preguntas</span>
                <p class="text-5xl font-black text-[#000000]">{{ count($survey->questions) }}</p>
            </div>
        </div>
    </div>

    {{-- Errores de validación --}}
    @if($errors->any())
        <div class="mb-10 bg-[#FFE5E5] border-l-4 border-[#F00000] p-6 shadow-md">
            <p class="text-[#F00000] font-bold uppercase text-sm tracking-wide mb-2">Por favor, revisa lo siguiente:</p>
            <ul class="list-disc list-inside text-sm text-[#F00000] font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employee.surveys.store', $survey) }}" method="POST" class="space-y-12">
        @csrf

        @foreach($survey->questions as $index => $question)
            {{-- Tarjeta de pregunta en estilo referente --}}
            <div class="bg-white shadow-xl border-t-4 border-[#000000] p-10 relative group transition-all duration-300 hover:shadow-2xl">
                
                {{-- Número de paso --}}
                <div class="mb-8">
                    <span class="text-[#F00000] font-black text-sm uppercase tracking-[0.2em]">Paso {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}/{{ str_pad(count($survey->questions), 2, '0', STR_PAD_LEFT) }}</span>
                </div>

                <div class="space-y-8">
                    <h2 class="text-3xl font-semibold text-[#000000] leading-tight tracking-tight">
                        {{ $question->question_text }}
                        @if($question->is_required)
                            <span class="text-[#F00000] ml-1">*</span>
                        @endif
                    </h2>

                    {{-- Opciones de respuesta --}}
                    <div class="pt-4">
                        {{-- Tipo: Escala (1-5) - Como en el referente --}}
                        @if($question->type === 'scale')
                            <div class="flex flex-wrap justify-between items-center gap-4 max-w-2xl">
                                @foreach(range(1, 5) as $value)
                                    <label class="relative flex flex-col items-center group cursor-pointer">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $value }}" class="peer sr-only" {{ old('answers.'.$question->id) == $value ? 'checked' : '' }} @if($question->is_required) required @endif>
                                        <div class="w-16 h-16 md:w-20 md:h-20 rounded-full border-4 border-gray-100 flex items-center justify-center text-2xl font-black text-gray-300 transition-all duration-300 peer-checked:border-[#F00000] peer-checked:bg-[#F00000] peer-checked:text-white peer-hover:border-gray-300">
                                            {{ $value }}
                                        </div>
                                        <span class="mt-3 text-[10px] font-bold uppercase tracking-widest text-gray-400 opacity-0 peer-checked:opacity-100 transition-opacity">
                                            @if($value == 1) Muy mal @elseif($value == 5) Excelente @endif
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                        {{-- Tipo: Texto --}}
                        @elseif($question->type === 'text')
                            <input type="text" name="answers[{{ $question->id }}]" value="{{ old('answers.'.$question->id) }}"
                                   class="w-full p-4 border-b-2 border-gray-200 focus:border-[#F00000] focus:ring-0 focus:outline-none bg-gray-50 text-xl transition-colors"
                                   placeholder="Escribe tu respuesta aquí..." @if($question->is_required) required @endif>

                        {{-- Tipo: Área de texto --}}
                        @elseif($question->type === 'textarea')
                            <textarea name="answers[{{ $question->id }}]" rows="4"
                                      class="w-full p-4 border-2 border-gray-100 focus:border-[#F00000] focus:ring-0 focus:outline-none bg-gray-50 text-lg transition-colors"
                                      placeholder="Comparte tus comentarios detallados..." @if($question->is_required) required @endif>{{ old('answers.'.$question->id) }}</textarea>

                        {{-- Tipo: Sí/No --}}
                        @elseif($question->type === 'boolean')
                            <div class="flex gap-6">
                                @foreach(['Si' => 'SÍ', 'No' => 'NO'] as $val => $label)
                                    <label class="flex-1 cursor-pointer group">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $val }}" class="peer sr-only" {{ old('answers.'.$question->id) == $val ? 'checked' : '' }} @if($question->is_required) required @endif>
                                        <div class="w-full py-4 border-2 border-gray-100 text-center font-black text-gray-400 transition-all peer-checked:border-[#000000] peer-checked:bg-[#000000] peer-checked:text-white uppercase tracking-widest group-hover:border-gray-300">
                                            {{ $label }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Botón de envío --}}
        <div class="pt-12 flex justify-center">
            <button type="submit" class="w-full md:w-auto bg-[#000000] text-white font-bold py-5 px-16 hover:bg-[#F00000] transition duration-300 uppercase tracking-[0.3em] text-lg shadow-2xl rounded-none">
                Finalizar y Enviar
            </button>
        </div>
    </form>
</div>
@endsection