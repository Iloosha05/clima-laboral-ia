<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HrController;


Route::get('/', function () {
    return view('welcome');
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

require __DIR__.'/auth.php';
