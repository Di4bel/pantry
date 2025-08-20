<?php

declare(strict_types=1);

use function Pest\Laravel\actingAs;

test('Recipe can be updated by creator', function (): void {
    $user = App\Models\User::factory()->create();
    $recipe = App\Models\Recipe::factory()->create(['creator_id' => $user->id]);
    actingAs($user);
    $result = $user->can('update', $recipe);
    expect($result)->toBeTrue();
});

test('Recipe can be updated', function (): void {
    $recipe = App\Models\Recipe::factory()->create();
    $action = new App\Actions\UpdateRecipeAction;
    $recipe = $action->handle($recipe, [
        'title' => 'Updated recipe',
        'description' => 'Updated recipe',
    ]);
    expect($recipe->title)->toBe('Updated recipe')
        ->and($recipe->description)->toBe('Updated recipe');
});

test('Recipe can not be assigned to not existent user', function (): void {
    $recipe = App\Models\Recipe::factory()->create();
    $action = new App\Actions\UpdateRecipeAction;
    $recipe = $action->handle($recipe, [
        'creator_id' => 3,
    ]);
})->throws(Exception::class);

test('Recipe can not be updated by other users', function (): void {
    $recipe = App\Models\Recipe::factory()->create();
    $user = App\Models\User::factory()->create();
    actingAs($user);
    $result = $user->can('update', $recipe);
    expect($result)->toBeFalse();
});

test('RecipeController can update a recipe', function (): void {
    $user = App\Models\User::factory()->create();
    $recipe = App\Models\Recipe::factory()->create(['creator_id' => $user->id]);

    $response = test()->actingAs($user)->put('/recipes/'.$recipe->id, [
        'title' => fake()->word(),
        'ingredients' => fake()->words(),
        'description' => fake()->paragraph(),
    ]);
    expect($response->getStatusCode())->toBe(200);
});
