<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $borrowedDate = fake()->dateTimeBetween('-30 days', 'now');
        $dueDate = clone $borrowedDate;
        $dueDate->modify('+7 days');

        $isReturned = fake()->boolean(70); // 70% chance of being returned
        $returnedDate = null;
        $status = 'borrowed';

        if ($isReturned) {
            $returnedDate = fake()->dateTimeBetween($borrowedDate, 'now');
            $status = 'returned';
        } elseif ($dueDate < now()) {
            $status = 'overdue';
        }

        return [
            'member_id' => Member::factory(),
            'book_id' => Book::factory(),
            'borrowed_by' => User::factory(),
            'returned_by' => $isReturned ? User::factory() : null,
            'borrowed_date' => $borrowedDate,
            'due_date' => $dueDate,
            'returned_date' => $returnedDate,
            'status' => $status,
            'notes' => fake()->optional()->sentence(),
            'fine_amount' => $status === 'overdue' || ($status === 'returned' && $returnedDate > $dueDate) 
                ? fake()->numberBetween(1000, 10000) 
                : 0,
            'fine_paid' => fake()->boolean(),
        ];
    }
}