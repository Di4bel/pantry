<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateRecipeAction;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Recipe;

final class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): void {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request, CreateRecipeAction $action): \Illuminate\Http\RedirectResponse
    {
        $recipe = $action->handle($request->user(), $request->validated());

        return to_route('recipes.show', $recipe);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @uses \App\Models\Recipe $recipe, UpdateRecipeRequest $request
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe): void
    {
        //
    }
}
