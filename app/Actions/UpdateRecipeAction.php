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
    public function handle(array $data,Recipe $recipe): void
    {
        DB::transaction(function () use ($data,$recipe): void {
            $recipe->update($data);
        });

        broadcast()->toOthers();
    }
}
