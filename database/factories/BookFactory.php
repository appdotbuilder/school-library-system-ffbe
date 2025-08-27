<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\BookShelf;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 10);

        return [
            'title' => fake()->sentence(3),
            'isbn' => fake()->unique()->isbn13(),
            'description' => fake()->paragraph(),
            'publication_year' => fake()->year(),
            'quantity' => $quantity,
            'available_quantity' => fake()->numberBetween(0, $quantity),
            'book_shelf_id' => BookShelf::factory(),
            'category_id' => Category::factory(),
            'author_id' => Author::factory(),
            'publisher_id' => Publisher::factory(),
        ];
    }
}