<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ShoppingList;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/** @extends Factory<ShoppingList> */
final class ShoppingListFactory extends Factory
{
    protected $model = ShoppingList::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'user_id' => User::factory()->create(),
            'closed_at' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function closed(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'closed_at' => Carbon::now(),
        ]);
    }
}
