<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;

final class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Recipe::factory(10)->create();
    }
}
