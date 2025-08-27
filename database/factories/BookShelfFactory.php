<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookShelf>
 */
class BookShelfFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $code = fake()->unique()->regexify('[A-Z][0-9]');
        
        return [
            'code' => $code,
            'name' => 'Shelf ' . $code,
            'description' => fake()->sentence(),
        ];
    }
}