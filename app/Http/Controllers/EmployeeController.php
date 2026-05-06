<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    //muestra el panel de empleado
    public function index()
    {
        $surveys = Survey::where('is_active', true)
            ->whereDoesntHave('respondents', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();
        
        return view('employee.dashboard', compact('surveys'));
    }

    //muestra el formulario de la encuesta
    public function show(Survey $survey)
    {
        if (!$survey->is_active) {
            return redirect()->route('dashboard')->with('error', 'Esta encuesta ya no está disponible.');
        }

        if ($survey->respondents()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('dashboard')->with('error', 'Ya has completado esta encuesta. ¡Gracias!');
        }

        $survey->load('questions');

        return view('employee.surveys.show', compact('survey'));
    }

    //guarda las respuestas en la base de datos
    public function store(Request $request, Survey $survey)
    {
        $survey->load('questions');

        //validar que se ha enviado al menos una respuesta
        $request->validate([
            'answers' => 'required|array',
        ], [
            'answers.required' => 'Debes responder al menos a una pregunta para enviar la encuesta.'
        ]);

        $validQuestionIds = $survey->questions->pluck('id')->all();

        //validación manual: comprobar que todas las obligatorias están respondidas
        foreach ($survey->questions as $question) {
            $answer = $request->answers[$question->id] ?? null;
            if ($question->is_required && trim((string) $answer) === '') {
                return back()->with('error', 'Por favor, responde a todas las preguntas obligatorias. Te faltó: "' . $question->text . '"');
            }
        }

        //crear el intento (submission) anónimo
        $submission = $survey->submissions()->create();

        //guardar cada respuesta en la base de datos
        foreach ($request->answers as $question_id => $answer_value) {
            $questionId = (int) $question_id;
            if (!in_array($questionId, $validQuestionIds, true)) {
                continue;
            }

            if (trim((string) $answer_value) === '') {
                continue;
            }

            $submission->answers()->create([
                'question_id' => $questionId,
                'answer_value' => $answer_value,
            ]);
        }

        //registrar que este usuario ya completó la encuesta (para que desaparezca del panel)
        Auth::user()->surveys()->attach($survey->id, [
            'completed_at' => now()
        ]);

        //redirigir con éxito
        return redirect()->route('dashboard')->with('success', '¡Gracias! Tus respuestas han sido enviadas de forma segura y anónima.');
    }
}