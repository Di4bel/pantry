<?php

declare(strict_types=1);

test('Recipe creator is User-Model', function () {
    $user = App\Models\User::factory()->create();
    $action = new App\Actions\CreateRecipeAction;
    $recipe = $action->handle($user, [
        'title' => fake()->word(),
        'ingredients' => fake()->words(),
        'description' => fake()->paragraph(),
    ]);

    expect($recipe->creator)->toBeInstanceOf(App\Models\User::class);
});
