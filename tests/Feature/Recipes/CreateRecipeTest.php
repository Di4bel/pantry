<?php

declare(strict_types=1);

use function Pest\Laravel\actingAs;

test('Recipe can be created via factory', function (): void {
    $recipe = App\Models\Recipe::factory()->create();

    expect($recipe)->toBeInstanceOf(App\Models\Recipe::class);
});

test('User can is authorized to create recipes', function (): void {
    $user = App\Models\User::factory()->create();
    actingAs($user);
    expect(Gate::authorize('create', App\Models\Recipe::class)->allowed())->toBeTrue();
});

test('RecipeAction can create a recipe', function (): void {
    $user = App\Models\User::factory()->create();
    $action = new App\Actions\CreateRecipeAction;
    $recipe = $action->handle($user, [
        'title' => fake()->word(),
        'ingredients' => fake()->words(),
        'description' => fake()->paragraph(),
    ]);
    expect($recipe)->toBeInstanceOf(App\Models\Recipe::class);
});

test('RecipeActions can fail', function (): void {
    $user = App\Models\User::factory()->create();
    $action = new App\Actions\CreateRecipeAction;
    $recipe = $action->handle($user, [
        'ingredients' => fake()->text(),
        'description' => fake()->paragraph(),
    ]);
})->throws(Exception::class);

test('RecipeActions can not massasign creator_id', function (): void {
    $user = App\Models\User::factory()->create();
    $action = new App\Actions\CreateRecipeAction;
    $recipe = $action->handle($user, [
        'title' => fake()->word(),
        'description' => fake()->paragraph(),
        'ingredients' => fake()->words(),
        'creator_id' => $user->id,
    ]);
})->throws(Exception::class);

test('RecipeController can be rendered', function (): void {
    $user = App\Models\User::factory()->create();
    $response = test()->actingAs($user)->get('/recipes/create');
    $response->assertStatus(200);
});
