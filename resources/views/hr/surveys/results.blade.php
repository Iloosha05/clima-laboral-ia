@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    {{-- Botón volver --}}
    <div class="mb-8">
        <a href="{{ route('hr.dashboard') }}" class="text-gray-500 hover:text-[#F00000] transition flex items-center gap-2 font-bold uppercase tracking-wider text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Volver al Panel
        </a>
    </div>

    {{-- Encabezado --}}
    <div class="bg-[#000000] text-white p-8 shadow-xl mb-10 flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <p class="text-[#F00000] font-bold tracking-widest uppercase text-sm mb-2">Reporte de Resultados</p>
            <h1 class="text-3xl font-bold">{{ $survey->title }}</h1>
        </div>
        <div class="bg-white text-[#000000] px-8 py-4 text-center border-b-4 border-[#F00000]">
            <span class="block text-4xl font-black">{{ $totalSubmissions }}</span>
            <span class="text-xs font-bold uppercase tracking-wider text-gray-500">Respuestas</span>
        </div>
    </div>

    @if($totalSubmissions === 0)
        <div class="bg-white p-12 text-center border-2 border-dashed border-gray-300">
            <p class="text-gray-500 font-medium text-lg">Aún no hay respuestas para esta encuesta.</p>
            <p class="text-gray-400 mt-2">Los resultados aparecerán aquí cuando los empleados comiencen a participar.</p>
        </div>
    @else
        <div class="space-y-8">
            @foreach($statistics as $index => $stat)
                <div class="bg-white p-8 shadow-sm border-t-4 border-[#000000]">
                    
                    {{-- Pregunta --}}
                    <h3 class="text-xl font-bold text-[#000000] mb-6 flex gap-2">
                        <span class="text-gray-300">{{ $index + 1 }}.</span> 
                        {{ $stat['question']->question_text }}
                    </h3>

                    <div class="pl-0 md:pl-8">
                        {{-- Visualización para tipo ESCALA (1-5) --}}
                        @if($stat['question']->type === 'scale')
                            <div class="flex items-center gap-6">
                                <div class="text-5xl font-black text-[#F00000]">
                                    {{ $stat['average'] }}
                                </div>
                                <div>
                                    <p class="text-gray-400 font-bold uppercase text-xs tracking-wider mb-1">Puntuación Media (sobre 5)</p>
                                    <div class="flex gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 {{ $i <= round($stat['average']) ? 'text-[#F00000]' : 'text-gray-200' }}" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>

                        {{-- Visualización para tipo boleano --}}
                        @elseif($stat['question']->type === 'boolean')
                            <div class="space-y-4">
                                {{-- Barra sí --}}
                                <div>
                                    <div class="flex justify-between text-sm font-bold mb-1">
                                        <span class="text-[#000000]">Sí ({{ $stat['yes_count'] }})</span>
                                        <span class="text-gray-500">{{ $stat['yes_percent'] }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 h-4">
                                        <div class="bg-[#000000] h-4 transition-all duration-1000" style="width: {{ $stat['yes_percent'] }}%"></div>
                                    </div>
                                </div>
                                {{-- Barra no --}}
                                <div>
                                    <div class="flex justify-between text-sm font-bold mb-1">
                                        <span class="text-[#F00000]">No ({{ $stat['no_count'] }})</span>
                                        <span class="text-gray-500">{{ $stat['no_percent'] }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-100 h-4">
                                        <div class="bg-[#F00000] h-4 transition-all duration-1000" style="width: {{ $stat['no_percent'] }}%"></div>
                                    </div>
                                </div>
                            </div>

                        {{-- Visualización para texto abierto --}}
                        @elseif(in_array($stat['question']->type, ['text', 'textarea']))
                            @if(count($stat['texts']) > 0)
                                
                                {{-- Botón para el analizis con IA --}}
                                <div class="mb-4">
                                    <button onclick="analyzeConIA({{ $stat['question']->id }}, this)" class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold py-2 px-4 rounded shadow-md hover:shadow-lg transition-all flex items-center gap-2 text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.381z" clip-rule="evenodd" />
                                        </svg>
                                        Resumir con IA
                                    </button>
                                    
                                    {{-- Caja donde aparecerá el resultado de la IA --}}
                                    <div id="ai-result-{{ $stat['question']->id }}" class="hidden mt-3 p-4 bg-purple-50 border-l-4 border-purple-500 text-purple-900 text-sm font-medium shadow-inner">
                                        Generando análisis... <span class="animate-pulse">⏳</span>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 max-h-64 overflow-y-auto space-y-3 border border-gray-100">
                                    @foreach($stat['texts'] as $textResponse)
                                        <div class="bg-white p-3 border-l-2 border-[#000000] text-sm text-gray-700 shadow-sm">
                                            "{{ $textResponse }}"
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-xs text-gray-400 mt-2 text-right">Mostrando {{ count($stat['texts']) }} respuestas</p>
                            @else
                                <p class="text-gray-400 italic text-sm">No hay respuestas de texto para esta pregunta.</p>
                            @endif
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- El script que llama a IA --}}
<script>
function analyzeConIA(questionId, btnElement) {
    // Mostrar la caja de carga
    const resultBox = document.getElementById('ai-result-' + questionId);
    resultBox.classList.remove('hidden');
    resultBox.innerHTML = 'Analizando respuestas con Inteligencia Artificial... <span class="animate-pulse">✨</span>';
    
    // Deshabilitar el botón para no hacer doble clic
    btnElement.disabled = true;
    btnElement.classList.add('opacity-50');

    // Enviar petición al servidor usando Fetch API
    fetch(`/hr/questions/${questionId}/analyze`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Mostrar el resumen bonito
        resultBox.innerHTML = '<strong>🤖 Conclusión de la IA:</strong><br>' + data.summary;
    })
    .catch(error => {
        resultBox.innerHTML = '<span class="text-red-500">Hubo un error de conexión con la IA.</span>';
    })
    .finally(() => {
        btnElement.disabled = false;
        btnElement.classList.remove('opacity-50');
    });
}
</script>
@endsection