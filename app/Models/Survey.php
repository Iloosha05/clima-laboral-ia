<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Survey extends Model
{
    use HasFactory;

    //campos permitidos
    protected $fillable = [
        'title', 
        'description', 
        'deadline', 
        'is_active', 
        'created_by'
    ];

    //conversión de tipos de datos
    protected $casts = [
        'deadline' => 'date',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones de base de datos
    |--------------------------------------------------------------------------
    */

    //la encuesta fue creada por un usuario hr
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    //una encuesta contiene múltiples preguntas
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    //una encuesta genera múltiples intentos
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    //N:M: Usuarios que ya han completado esta encuesta
    //alimenta la tabla intermedia survey_user para saber quién ya participó
    public function respondents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'survey_user')
                    ->withPivot('completed_at')
                    ->withTimestamps();
    }
}