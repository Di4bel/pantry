<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ShoppingListItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ShoppingListItem>
 */
final class ShoppingListItemFactory extends Factory
{
    protected $model = ShoppingListItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'shopping_list_id' => ShoppingListItem::factory(),
            'name' => $this->faker->word(),
            'amount' => $this->faker->randomDigit(),
            'amount_type' => $this->faker->randomElement(['kg', 'l', 'ml', 'g', 'pcs']),
            'price' => $this->faker->randomNumber(5),
        ];
    }
}
