<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MoodEntry;

class MoodController extends Controller
{
    public function create()
    {
        return view('mood.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mood' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:255',
        ]);

        MoodEntry::create([
            'user_id' => auth()->id(),
            'mood' => $request->mood,
            'comment' => $request->comment,
        ]);

        return redirect()->route('mood.create')->with('success', 'Encuesta enviada correctamente');
    }
}
