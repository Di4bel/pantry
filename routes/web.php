<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function (): void {
    Route::redirect('settings', 'pages::settings/profile');

    Route::livewire('settings/profile', 'pages::settings.profile')->name('settings.profile');
    Route::livewire('settings/password', 'pages::settings.password')->name('settings.password');
    Route::livewire('settings/appearance', 'pages::settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::livewire('recipes', 'pages::recipes.recipe-index')->name('recipes.index');
    Route::livewire('recipes/create', 'pages::recipes.recipe-create')->name('recipes.create');
    Route::livewire('recipes/{recipe}', 'pages::recipes.recipe-show')->name('recipes.show');
    Route::livewire('recipes/{recipe}/edit', 'pages::recipes.recipe-edit')->name('recipes.edit');
    Route::livewire('users/{user}', 'pages::users.user-show')->name('users.show');
});

require __DIR__.'/auth.php';
