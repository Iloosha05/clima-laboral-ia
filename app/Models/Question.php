<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id', 
        'question_text', 
        'type', 
        'options', 
        'is_required'
    ];

    protected $casts = [
        'options' => 'array', //Convierta un json a un array
        'is_required' => 'boolean',
    ];

    // Una pregunta pertenece a una encuesta
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    // Cada pregunta puede tener varias respuestas
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}