<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MoodEntry;

class HrController extends Controller
{
    public function index()
    {
        return view('hr.dashboard', [
            'avgMood' => MoodEntry::avg('mood'),
            'entries' => MoodEntry::latest()->take(10)->get(),
        ]);
    }
}

