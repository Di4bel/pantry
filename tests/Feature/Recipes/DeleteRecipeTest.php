<?php

declare(strict_types=1);

use function Pest\Laravel\actingAs;

test('only Creator can delete Models', function (): void {
    $user = App\Models\User::factory()->create();
    $allowedRecipe = App\Models\Recipe::factory()->create(['creator_id' => $user->id]);
    $prohibitedRecipe = App\Models\Recipe::factory()->create();
    actingAs($user);
    expect(Gate::authorize('delete', $allowedRecipe)->allowed())->toBeTrue()
        ->and(Gate::check('delete', $prohibitedRecipe))->toBeFalse();
});

test('recipe delete via action', function (): void {
    $user = App\Models\User::factory()->create();
    $recipe = App\Models\Recipe::factory()->create(['creator_id' => $user->id]);
    $action = new App\Actions\DeleteRecipeAction();
    $action->handle($recipe);
    $this->assertDatabaseMissing('recipes', ['id' => $recipe->id]);
});
