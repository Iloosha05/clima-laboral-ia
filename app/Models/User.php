<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // app/Models/User.php
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Comprobar, si el usuario es HR
    public function isHr()
    {
        return $this->role === 'hr';
    }

    // Encuestas que ha creado un HR
    public function createdSurveys()
    {
        return $this->hasMany(Survey::class, 'created_by');
    }

    // Encuestas que ha superado un empleado
    public function completedSurveys()
    {
        return $this->belongsToMany(Survey::class, 'survey_user')
                    ->withPivot('completed_at')
                    ->withTimestamps();
    }

    public function moodEntries()
    {
        return $this->hasMany(MoodEntry::class);
    }

}
