<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'category_id' => $this->faker->numberBetween(1),
            'status' => $this->faker->numberBetween(0, 1),
            'condition' => $this->faker->text(),
            'quantity_item' => $this->faker->numberBetween(1, 10),
        ];
    }
}
