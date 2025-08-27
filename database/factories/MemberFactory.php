<?php

namespace Database\Factories;

use App\Models\Major;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $memberType = fake()->randomElement(['student', 'teacher', 'staff']);

        return [
            'nisn_nip' => fake()->unique()->numerify('##########'),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'member_type' => $memberType,
            'status' => fake()->randomElement(['active', 'inactive']),
            'school_class_id' => $memberType === 'student' ? SchoolClass::factory() : null,
            'major_id' => $memberType === 'student' ? Major::factory() : null,
            'joined_date' => fake()->date(),
        ];
    }
}