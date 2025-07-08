<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateRecipeAction;
use App\Actions\UpdateRecipeAction;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Recipe;

final class RecipeController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request, CreateRecipeAction $action): \Illuminate\Http\RedirectResponse
    {
        $recipe = $action->handle($request->user(), $request->validated());

        return to_route('recipes.show', $recipe);
    }

    /**
     * Update the specified resource in storage.
     *
     * @uses \App\Models\Recipe $recipe, UpdateRecipeRequest $request
     */
    public function update(UpdateRecipeRequest $request, UpdateRecipeAction $action, Recipe $recipe): void
    {
        $action->handle($recipe, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe): void
    {
        //
    }
}
