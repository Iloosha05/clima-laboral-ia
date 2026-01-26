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
| HR routes (solo para usuarios con rol HR)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'hr'])->group(function () {
    Route::get('/hr/dashboard', [HrController::class, 'index'])
        ->name('hr.dashboard');
});

/*
|--------------------------------------------------------------------------
| Mood routes 
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/mood', [MoodController::class, 'create'])->name('mood.create');
    Route::post('/mood', [MoodController::class, 'store'])->name('mood.store');
});

require __DIR__.'/auth.php';
