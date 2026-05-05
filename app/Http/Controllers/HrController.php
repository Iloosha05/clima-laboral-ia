<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HrController extends Controller
{
    public function index()
    {
        $surveys = Survey::where('created_by', Auth::id())->latest()->get();
        return view('hr.dashboard', compact('surveys'));
    }

    //muestra el formulario para crear una nueva encuesta
    public function create()
    {
        return view('hr.surveys.create');
    }

    //guarda los datos de la encuesta y redirige a la creación de preguntas
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date|after_or_equal:today',
        ]);

        //guardamos la encuesta en una variable para obtener su ID
        $survey = \App\Models\Survey::create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'is_active' => true, 
            'created_by' => Auth::id(), 
        ]);

        //redirigimos directamente a la pantalla de añadir preguntas
        return redirect()->route('hr.questions.create', $survey->id)
                         ->with('success', 'Encuesta creada. Ahora añade las preguntas.');
    }

    //elimina una encuesta de la base de datos
    public function destroy(Survey $survey)
    {
        //verificamos que el HR actual sea el dueño
        if ($survey->created_by !== Auth::id()) {
            abort(403, 'No tienes permiso para eliminar esta encuesta.');
        }

        $survey->delete();

        return redirect()->route('hr.dashboard')->with('success', 'Encuesta eliminada correctamente.');
    }

    //muestra las estadísticas y resultados de la encuesta
    public function results(Survey $survey)
    {
        //solo el creador puede ver los resultados
        if ($survey->created_by !== Auth::id()) {
            abort(403, 'No tienes permiso para ver estos resultados.');
        }

        //total de empleados que han completado la encuesta
        $totalSubmissions = $survey->submissions()->count();

        //recopilamos y calculamos las estadísticas para cada pregunta
        $statistics = [];
        foreach ($survey->questions as $question) {
            //obtenemos todos los valores de respuesta para esta pregunta (sin depender de relaciones complejas)
            $answers = \DB::table('answers')->where('question_id', $question->id)->pluck('answer_value');
            
            $stats = [
                'question' => $question,
                'total_answers' => $answers->count(),
            ];

            if ($question->type === 'scale') {
                $numericAnswers = $answers->filter(fn($val) => is_numeric($val))->map(fn($val) => (float) $val);
                $stats['average'] = $numericAnswers->count() > 0 ? round($numericAnswers->avg(), 1) : 0;
                
            } elseif ($question->type === 'boolean') {
                //calculamos porcentajes de Sí / No
                $yes = $answers->filter(fn($val) => strtolower($val) === 'si')->count();
                $no = $answers->filter(fn($val) => strtolower($val) === 'no')->count();
                $total = $yes + $no;
                
                $stats['yes_percent'] = $total > 0 ? round(($yes / $total) * 100) : 0;
                $stats['no_percent'] = $total > 0 ? round(($no / $total) * 100) : 0;
                $stats['yes_count'] = $yes;
                $stats['no_count'] = $no;
            } elseif (in_array($question->type, ['text', 'textarea'])) {
                //guardamos los textos que no estén vacíos
                $stats['texts'] = $answers->filter(fn($val) => !empty($val))->values();
            }

            $statistics[] = $stats;
        }

        return view('hr.surveys.results', compact('survey', 'totalSubmissions', 'statistics'));
    }

    //analizar respuestas de texto con la IA
    public function analyzeAnswersWithAi(Request $request, \App\Models\Question $question)
    {
        //recopilamos las respuestas de texto para esta pregunta
        $answers = \DB::table('answers')
            ->where('question_id', $question->id)
            ->whereNotNull('answer_value')
            ->pluck('answer_value')
            ->map(fn($val) => trim($val)) // Quitamos espacios en blanco
            ->filter(fn($val) => $val !== '') // Eliminamos las vacías
            ->toArray();

        if (count($answers) === 0) {
            return response()->json(['summary' => 'No hay suficientes datos de texto para analizar.']);
        }

        //preparamos un prompt
        $respuestasUnidas = implode(" | ", $answers);
        $prompt = "Eres un analista de RRHH. Analiza estas respuestas anónimas y devuelve el resultado EXACTAMENTE con esta estructura (respeta los saltos de línea y NO incluyas ninguna frase de introducción como 'A continuación' o 'Aquí tienes'):

        PUNTOS CLAVE:
        • [Tema principal 1]: [Breve resumen]
        • [Tema principal 2]: [Breve resumen]

        CONSEJO DE RRHH:
        [Escribe aquí una recomendación accionable y profesional para solucionar estos problemas detectados].

        Respuestas a analizar: " . $respuestasUnidas;
        //enviamos la petición a Groq
        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un asistente de RRHH experto en clima laboral. Responde siempre en español.'],
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.5,
            ]);

            $result = $response->json();

            //si la API devuelve un error oficial, lo mostramos en pantalla
            if (isset($result['error'])) {
                return response()->json(['summary' => 'Error de Groq: ' . $result['error']['message']]);
            }

            //si por alguna razón la estructura es rara, imprimimos todo para depurar
            $summary = $result['choices'][0]['message']['content'] ?? 'Error desconocido: ' . json_encode($result);

            return response()->json(['summary' => $summary]);

        } catch (\Exception $e) {
            return response()->json(['summary' => 'Error de conexión con la IA: ' . $e->getMessage()], 500);
        }
    }

    public function edit(Survey $survey)
    {
        return view('hr.surveys.edit', compact('survey'));
    }

    public function update(Request $request, Survey $survey)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date|after_or_equal:today',
        ]);

        $survey->update([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('hr.dashboard')->with('success', 'Encuesta actualizada correctamente');
    }
}