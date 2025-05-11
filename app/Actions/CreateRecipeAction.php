<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class CreateRecipeAction
{
    /**
     * Execute the action.
     *
     * @throws Throwable
     */
    public function handle(User $user, array $data): Recipe
    {
        return DB::transaction(function () use ($user, $data): Recipe {
            return $user->recipes()->create($data);
        });
    }
}
