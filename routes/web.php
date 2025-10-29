<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MealController;
use App\Http\Controllers\SupportController;

Route::get('/', fn () => redirect()->route('meals.index'));

Route::middleware(['auth'])->group(function () {
    Route::resource('meals', MealController::class);
     Route::get('/calendar', [\App\Http\Controllers\CalendarController::class, 'index'])
        ->name('calendar.index');                
    Route::get('/calendar/day/{date}', [\App\Http\Controllers\CalendarController::class, 'day'])
        ->name('calendar.day');                
    Route::get('/support/patients/{user}/calendar', [\App\Http\Controllers\SupportCalendarController::class, 'index'])
        ->middleware('can:supporter-only')
        ->name('support.calendar.index');
    Route::get('/support/patients/{user}/calendar/day/{date}', [\App\Http\Controllers\SupportCalendarController::class, 'day'])
        ->middleware('can:supporter-only')
        ->name('support.calendar.day');
});

Route::middleware(['auth','can:supporter-only'])->group(function(){
    Route::get('/support/patients/{user}/meals', [SupportController::class,'meals'])
        ->name('support.patients.meals');
});

Route::get('/dashboard', function () {
    return redirect()->route('meals.index');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';