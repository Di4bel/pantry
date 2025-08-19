<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Recipe;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class UpdateRecipeAction
{
    /**
     * Execute the action.
     *
     * @throws Throwable
     */
    public function handle(Recipe $recipe, array $data): Recipe
    {

        DB::transaction(function () use ($data, $recipe): void {
            $recipe->update($data);
        });

        // TODO: add Event and Listeners
        broadcast('Recipe:'.$recipe->id.' updated')->toOthers();

        return $recipe;
    }
}
