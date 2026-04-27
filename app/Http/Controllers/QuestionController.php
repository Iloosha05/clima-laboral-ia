<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //mostrar el formulario
    public function create(Survey $survey)
    {
        //obtenemor las preguntas que ya pertenecen a esta encuesta
        $questions = $survey->questions()->get();
        
        return view('hr.questions.create', compact('survey', 'questions'));
    }

    //guardar una nueva pregunta
    public function store(Request $request, Survey $survey)
    {
        //validación
        $request->validate([
        'text' => 'required|string|max:500', 
        'type' => 'required|in:text,textarea,scale,boolean',
        'is_required' => 'boolean',
    ]);

        //creación de la pregunta vinculada a la encuesta
        $survey->questions()->create([
            // ИСПРАВЛЕНО: берем данные из $request->text
            'question_text' => $request->text, 
            'type' => $request->type,
            'is_required' => $request->has('is_required'), // true si el checkbox está marcado
        ]);

        //recargar la página con mensaje de éxito
        return back()->with('success', '¡Pregunta añadida correctamente!');
    }
}
