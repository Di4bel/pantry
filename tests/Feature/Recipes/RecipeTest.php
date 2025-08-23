<?php

declare(strict_types=1);

use function Pest\Laravel\actingAs;

test('Recipe creator is User-Model', function (): void {
    $user = App\Models\User::factory()->create();
    $action = new App\Actions\CreateRecipeAction;
    $recipe = $action->handle($user, [
        'title' => fake()->word(),
        'ingredients' => fake()->words(),
        'description' => fake()->paragraph(),
    ]);

    expect($recipe->creator)->toBeInstanceOf(App\Models\User::class);
});

test('anyone can viewAny Models', function (): void {
    expect(Gate::check('viewAny', App\Models\Recipe::class))->toBeTrue();
});

test('any user can view Models', function (): void {
    $user = App\Models\User::factory()->create();
    $recipe = App\Models\Recipe::factory()->create();
    actingAs($user);
    expect(Gate::authorize('view', $recipe)->allowed())->toBeTrue();
});
