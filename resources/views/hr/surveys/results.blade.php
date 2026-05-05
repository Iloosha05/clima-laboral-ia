@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    {{-- Botón volver --}}
    <div class="mb-8">
        <a href="{{ route('hr.dashboard') }}" class="text-gray-500 hover:text-[#F00000] transition flex items-center gap-2 font-medium uppercase tracking-wider text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Volver al Panel
        </a>
    </div>

    {{-- Encabezado --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 border-b-2 border-[#000000] pb-8 mb-12">
        <div>
            <span class="text-[#F00000] font-medium uppercase tracking-[0.2em] text-[10px]">Resultados de Encuesta</span>
            <h1 class="text-4xl font-medium text-[#000000] mt-2 tracking-tight uppercase">{{ $survey->title }}</h1>
            <p class="text-gray-500 mt-2 font-medium text-sm">Estado: <span class="text-[#000000]">{{ $survey->is_active ? 'Activa' : 'Finalizada' }}</span></p>
        </div>

        <div class="flex gap-12">
            <div class="text-right">
                <span class="text-[10px] font-medium text-gray-400 uppercase tracking-widest block mb-1">Respuestas Totales</span>
                <p class="text-5xl font-medium text-[#000000] tracking-tighter">{{ $totalSubmissions }}</p>
            </div>
        </div>
    </div>

    @if($totalSubmissions == 0)
        <div class="bg-white border-l-4 border-[#000000] p-10 shadow-md">
            <p class="text-gray-600 font-medium text-lg text-center italic">Aun no se han recibido respuestas para esta encuesta.</p>
        </div>
    @else
        <div class="space-y-12">
            @foreach($statistics as $index => $stat)
                @php $question = $stat['question']; @endphp

                <div class="bg-white shadow-xl border-t-4 border-[#000000] p-10">
                    <div class="flex gap-6 mb-8">
                        <span class="text-3xl font-medium text-gray-200 tracking-tighter">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <h2 class="text-2xl font-medium text-[#000000] tracking-tight leading-snug">{{ $question->question_text }}</h2>
                    </div>

                    <div class="md:pl-12">
                        @if($question->type == 'scale')
                            <div class="flex items-center gap-6 border-l-4 border-[#F00000] bg-gray-50 p-8">
                                <span class="text-6xl font-medium text-[#000000] tracking-tighter">{{ $stat['average'] }}</span>
                                <span class="text-xs font-medium text-gray-400 uppercase tracking-[0.2em]">Promedio sobre 5</span>
                            </div>

                        @elseif($question->type == 'boolean')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 p-8 border border-gray-100 text-center">
                                    <span class="block text-[10px] font-medium text-gray-400 uppercase tracking-widest mb-2">Opción SÍ</span>
                                    <p class="text-4xl font-medium text-[#000000]">{{ $stat['yes_percent'] ?? 0 }}%</p>
                                    <p class="text-[10px] text-gray-400 mt-2 font-medium uppercase tracking-wide">{{ $stat['yes_count'] ?? 0 }} respuestas</p>
                                </div>
                                <div class="bg-gray-50 p-8 border border-gray-100 text-center">
                                    <span class="block text-[10px] font-medium text-gray-400 uppercase tracking-widest mb-2">Opción NO</span>
                                    <p class="text-4xl font-medium text-[#000000]">{{ $stat['no_percent'] ?? 0 }}%</p>
                                    <p class="text-[10px] text-gray-400 mt-2 font-medium uppercase tracking-wide">{{ $stat['no_count'] ?? 0 }} respuestas</p>
                                </div>
                            </div>

                        @elseif(in_array($question->type, ['text', 'textarea']))
                            <div class="space-y-6">
                                <div class="flex justify-between items-center mb-4 pb-2 border-b border-gray-100">
                                    <h3 class="text-[10px] font-medium text-gray-400 uppercase tracking-widest italic">Comentarios y respuestas abiertas</h3>
                                    
                                    <button onclick="analyzeConIA({{ $question->id }}, this)" 
                                            class="bg-blue-600 text-white text-[10px] font-medium py-2.5 px-5 uppercase tracking-widest hover:bg-blue-700 transition-colors">
                                        Analizar con IA
                                    </button>
                                </div>

                                <div id="ai-result-{{ $question->id }}" class="hidden mb-8 bg-blue-50 border-l-4 border-blue-600 p-8 text-sm text-[#000000] leading-relaxed shadow-sm">
                                </div>

                                <div class="max-h-72 overflow-y-auto space-y-4 pr-4 custom-scrollbar">
                                    @if(!empty($stat['texts']) && count($stat['texts']) > 0)
                                        @foreach($stat['texts'] as $ansText)
                                            <div class="bg-gray-50 p-5 border-l border-gray-200 text-gray-600 text-sm italic leading-relaxed">
                                                "{{ $ansText }}"
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-gray-400 italic text-sm">No se han recibido comentarios para esta pregunta todavía.</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
function analyzeConIA(questionId, btnElement) {
    const resultBox = document.getElementById('ai-result-' + questionId);
    resultBox.classList.remove('hidden');
    resultBox.innerHTML = '<div class="flex items-center gap-3 text-blue-600 font-medium text-xs uppercase tracking-widest"><div class="animate-spin rounded-full h-4 w-4 border-2 border-blue-600 border-t-transparent"></div> Procesando datos...</div>';
    
    btnElement.disabled = true;
    btnElement.classList.add('opacity-50');

    fetch(`/hr/questions/${questionId}/analyze`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        resultBox.innerHTML = '<div class="font-medium mb-3 uppercase tracking-widest text-[10px] text-blue-600">Informe Generado por IA</div><div class="text-gray-800 font-normal whitespace-pre-line">' + data.summary + '</div>';
    })
    .catch(error => {
        resultBox.innerHTML = '<span class="text-red-500 font-medium text-xs uppercase">Error en el análisis.</span>';
    })
    .finally(() => {
        btnElement.disabled = false;
        btnElement.classList.remove('opacity-50');
    });
}
</script>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #000; }
</style>
@endsection