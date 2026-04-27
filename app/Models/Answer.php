<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'question_id', 
        'answer_value'
    ];

    //una respuesta pertenece a una pregunta concreta
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}