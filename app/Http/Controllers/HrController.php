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

    // MUESTRA EL FORMULARIO PARA CREAR LA ENCUESTA
    public function create()
    {
        return view('hr.surveys.create');
    }

    // GUARDA LOS DATOS EN LA BASE DE DATOS
    public function store(Request $request)
    {
        // Valida los datos introducidos por el usuario
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date|after_or_equal:today',
        ]);

        // Crea гт registro en la BD
        \App\Models\Survey::create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'is_active' => true, // true, porque en el modelo (Survey.php) es un boolean
            'created_by' => \Illuminate\Support\Facades\Auth::id(), // ID del HR actual
        ]);

        // Redirección al panel principal con mensaje de éxito
        return redirect()->route('hr.dashboard')->with('success', '¡Encuesta creada con éxito!');
    }
}