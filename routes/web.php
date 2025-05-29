<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function (): void {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth', 'verified'])->group(function (): void {
    Volt::route('recipes', 'recipes.recipe-index')->name('recipes.index');
    Volt::route('recipes/create', 'recipes.recipe-create')->name('recipes.create');
    Volt::route('recipes/{recipe}', 'recipes.recipe-show')->name('recipes.show');
    Route::post('recipes/store', [App\Http\Controllers\RecipeController::class, 'store'])->name('recipes.store');
});

require __DIR__.'/auth.php';