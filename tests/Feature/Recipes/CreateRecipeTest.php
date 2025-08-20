<?php

declare(strict_types=1);

test('Recipe can be created', function (): void {
    $recipe = App\Models\Recipe::factory()->create();

    expect($recipe)->toBeInstanceOf(App\Models\Recipe::class);
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

test('RecipeController can create a recipe', function (): void {
    $user = App\Models\User::factory()->create();

    $response = test()->actingAs($user)->post('/recipes/store', [
        'title' => fake()->word(),
        'ingredients' => fake()->words(),
        'description' => fake()->paragraph(),
        'creator_id' => $user->id,
    ]);

    $response->assertSessionHasNoErrors();

    $user->refresh();

    $recipe = $user->recipes()->first();
    $response->assertRedirect(route('recipes.show', $recipe));
});
