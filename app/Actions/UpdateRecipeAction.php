<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Recipe;
use Illuminate\Support\Facades\DB;

final readonly class UpdateRecipeAction
{
    /**
     * Execute the action.
     */
    public function handle(Recipe $recipe, array $data): void
    {

        DB::transaction(function () use ($data, $recipe): void {
            $recipe->update($data);
        });

        // TODO: add Event and Listeners
        broadcast('Recipe:'.$recipe->id.' updated')->toOthers();
    }
}
