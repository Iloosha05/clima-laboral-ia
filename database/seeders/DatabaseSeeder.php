<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Submission;
use App\Models\Answer;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear el usuario de Recursos Humanos (HR)
        $hrUser = User::create([
            'name' => 'Admin RRHH',
            'email' => 'hr@clab.com',
            'password' => Hash::make('password'),
            'role' => 'hr',
            'email_verified_at' => now(),
        ]);

        // 2. Crear usuarios Empleados
        $empleado1 = User::create([
            'name' => 'Ilia Zilber',
            'email' => 'ilia@clab.com',
            'password' => Hash::make('password'),
            'role' => 'empleado',
            'email_verified_at' => now(),
        ]);

        $empleado2 = User::create([
            'name' => 'María García',
            'email' => 'maria@clab.com',
            'password' => Hash::make('password'),
            'role' => 'empleado',
            'email_verified_at' => now(),
        ]);

        $empleado3 = User::create([
            'name' => 'Carlos López',
            'email' => 'carlos@clab.com',
            'password' => Hash::make('password'),
            'role' => 'empleado',
            'email_verified_at' => now(),
        ]);

        // 3. Crear Encuesta 1: Lista para analizar con IA (Ya tiene respuestas)
        $survey1 = Survey::create([
            'title' => 'Evaluación de Clima Laboral - Q1 2026',
            'description' => 'Encuesta trimestral para evaluar el bienestar del equipo, la comunicación y los recursos disponibles.',
            'deadline' => Carbon::now()->addDays(10),
            'is_active' => true,
            'created_by' => $hrUser->id,
        ]);

        // Preguntas para la Encuesta 1
        $s1q1 = Question::create([
            'survey_id' => $survey1->id,
            'question_text' => '¿Cómo calificarías tu nivel de satisfacción general en la empresa?',
            'type' => 'scale',
            'is_required' => true,
        ]);

        $s1q2 = Question::create([
            'survey_id' => $survey1->id,
            'question_text' => '¿Sientes que tienes las herramientas necesarias para realizar tu trabajo?',
            'type' => 'boolean',
            'is_required' => true,
        ]);

        $s1q3 = Question::create([
            'survey_id' => $survey1->id,
            'question_text' => '¿Qué aspectos mejorarías de la comunicación interna o del entorno de trabajo?',
            'type' => 'textarea',
            'is_required' => true,
        ]);

        // Simular respuestas de empleados a la Encuesta 1
        $respuestasTextuales = [
            "Falta más comunicación entre los departamentos. A veces hacemos trabajo doble porque no sabemos en qué está el otro equipo.",
            "Me gustaría tener reuniones de equipo más cortas y directas al grano. Perdemos mucho tiempo en videollamadas innecesarias.",
            "Todo está bastante bien, pero el software de gestión de proyectos que usamos es un poco lento y retrasa las tareas diarias."
        ];

        $empleadosRespondieron = [$empleado1, $empleado2, $empleado3];

        foreach ($empleadosRespondieron as $index => $empleado) {
            // Registrar que el empleado completó la encuesta
            $empleado->surveys()->attach($survey1->id, ['completed_at' => now()]);

            // Crear el envío anónimo
            $submission = Submission::create(['survey_id' => $survey1->id]);

            // Crear las respuestas para ese envío
            Answer::create([
                'submission_id' => $submission->id,
                'question_id' => $s1q1->id,
                'answer_value' => rand(3, 5), // Respuestas numéricas aleatorias entre 3 y 5
            ]);

            Answer::create([
                'submission_id' => $submission->id,
                'question_id' => $s1q2->id,
                'answer_value' => $index % 2 == 0 ? 'Si' : 'No', // Mezclar respuestas booleanas
            ]);

            Answer::create([
                'submission_id' => $submission->id,
                'question_id' => $s1q3->id,
                'answer_value' => $respuestasTextuales[$index], // Texto rico para la IA
            ]);
        }

        // 4. Crear Encuesta 2: Nueva, sin respuestas (Para grabar en video cómo se responde)
        $survey2 = Survey::create([
            'title' => 'Feedback sobre el nuevo formato de teletrabajo',
            'description' => 'Queremos conocer tu opinión sobre el modelo híbrido implementado este mes.',
            'deadline' => Carbon::now()->addDays(5),
            'is_active' => true,
            'created_by' => $hrUser->id,
        ]);

        Question::create([
            'survey_id' => $survey2->id,
            'question_text' => '¿Prefieres el modelo híbrido actual frente al 100% presencial?',
            'type' => 'boolean',
            'is_required' => true,
        ]);

        Question::create([
            'survey_id' => $survey2->id,
            'question_text' => '¿Cuál es el mayor desafío que encuentras al trabajar desde casa?',
            'type' => 'text',
            'is_required' => true,
        ]);
        
        Question::create([
            'survey_id' => $survey2->id,
            'question_text' => 'Del 1 al 5, ¿qué tan productivo te sientes en casa?',
            'type' => 'scale',
            'is_required' => false,
        ]);
    }
}
