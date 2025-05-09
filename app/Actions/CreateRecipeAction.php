<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class CreateRecipeAction
{
    /**
     * Execute the action.
     * @param User $user
     * @param array $data
     * @throws \Throwable
     */
    public function handle(User $user, array $data): void
    {
        DB::transaction(function () use ($user,$data): void {
            $user->recipes()->create($data);
        });

    }
}
