<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MoodController;
use App\Http\Controllers\HrController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('start');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Rutas HR (solo para usuarios con rol hr)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'hr'])->group(function () {
    Route::get('/hr/dashboard', [HrController::class, 'index'])->name('hr.dashboard');
    Route::get('/hr/surveys/create', [HrController::class, 'create'])->name('hr.surveys.create');
    Route::post('/hr/surveys', [HrController::class, 'store'])->name('hr.surveys.store');

    Route::get('/hr/surveys/{survey}/questions', [\App\Http\Controllers\QuestionController::class, 'create'])->name('hr.questions.create');
    Route::post('/hr/surveys/{survey}/questions', [\App\Http\Controllers\QuestionController::class, 'store'])->name('hr.questions.store');

    Route::delete('/hr/surveys/{survey}', [App\Http\Controllers\HrController::class, 'destroy'])->name('hr.surveys.destroy');

    Route::get('/hr/surveys/{survey}/results', [HrController::class, 'results'])->name('hr.surveys.results');
});

/*
|--------------------------------------------------------------------------
| Rutas comunes y empleados
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/mood', [MoodController::class, 'create'])->name('mood.create');
    Route::post('/mood', [MoodController::class, 'store'])->name('mood.store');
});

require __DIR__.'/auth.php';

//rutas para panel de empleados
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\EmployeeController::class, 'index'])->name('dashboard');
    Route::get('/surveys/{survey}/take', [\App\Http\Controllers\EmployeeController::class, 'show'])->name('employee.surveys.show');
    Route::post('/surveys/{survey}/take', [\App\Http\Controllers\EmployeeController::class, 'store'])->name('employee.surveys.store');
});

//rutas para los nalizis con IA
Route::post('/hr/questions/{question}/analyze', [App\Http\Controllers\HrController::class, 'analyzeAnswersWithAi'])->name('hr.questions.analyze');