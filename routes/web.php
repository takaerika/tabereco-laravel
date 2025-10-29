<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealController;
use App\Http\Controllers\SupportController;

Route::get('/', fn () => redirect()->route('meals.index'));

Route::middleware(['auth'])->group(function () {
    Route::resource('meals', MealController::class);
});

Route::middleware(['auth','can:supporter-only'])->group(function(){
    Route::get('/support/patients/{user}/meals', [SupportController::class,'meals'])
        ->name('support.patients.meals');
});

Route::get('/dashboard', function () {
    return redirect()->route('meals.index');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';