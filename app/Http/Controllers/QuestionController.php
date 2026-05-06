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
            'question_text' => $request->text, 
            'type' => $request->type,
            'is_required' => $request->boolean('is_required'), // true si el checkbox está marcado
        ]);

        //recargar la página con mensaje de éxito
        return back()->with('success', '¡Pregunta añadida correctamente!');
    }

    public function edit(Question $question)
    {
        return view('hr.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'text' => 'required|string|max:500', 
            'type' => 'required|in:text,textarea,scale,boolean',
            'is_required' => 'boolean',
        ]);

        $question->update([
            'question_text' => $request->text, 
            'type' => $request->type,
            'is_required' => $request->boolean('is_required'),
        ]);

        return redirect()->route('hr.questions.create', $question->survey_id)->with('success', 'Pregunta actualizada correctamente');
    }

    public function destroy(Question $question)
    {
        $survey_id = $question->survey_id;
        $question->delete();

        return redirect()->route('hr.questions.create', $survey_id)->with('success', 'Pregunta eliminada correctamente');
    }
}
