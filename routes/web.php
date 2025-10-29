<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealController;

Route::get('/', fn () => redirect()->route('meals.index'));

Route::middleware(['auth'])->group(function () {
    Route::resource('meals', MealController::class);
});

Route::get('/dashboard', function () {
    return redirect()->route('meals.index');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';