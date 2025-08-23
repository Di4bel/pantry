<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Recipe;
use Illuminate\Support\Facades\DB;

final readonly class DeleteRecipeAction
{
    /**
     * Execute the action.
     */
    public function handle(Recipe $recipe): void
    {
        DB::transaction(function () use ($recipe): void {
            $recipe->delete();
        });
    }
}
