<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
final class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->colorName(),
            'description' => $this->faker->text(),
            'ingredients' => function () {
                $times = $this->faker->randomDigit() + 1;
                $array = [];
                for ($i = 0; $i < $times; $i++) {
                    $array[] = [
                        'name' => $this->faker->word(),
                        'amount' => $this->faker->randomDigit(),
                        'type' => $this->faker->randomElement([
                            'count',
                            'kg',
                            'ml',
                            'l',
                            'g',
                            'tbsp',
                            'tsp',
                        ]),
                    ];
                }

                return $array;
            },
            'creator_id' => User::factory()->create(),
        ];
    }
}
