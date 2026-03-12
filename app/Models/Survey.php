<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'deadline', 
        'is_active', 
        'created_by'
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_active' => 'boolean',
    ];

    // La encuesta pertenece a HR
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // En una encuesta hay varias preguntas
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Empleados que han contrstado la encuesta
    public function respondents()
    {
        return $this->belongsToMany(User::class, 'survey_user')
                    ->withPivot('completed_at')
                    ->withTimestamps();
    }
}