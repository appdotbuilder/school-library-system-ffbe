<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Major>
 */
class MajorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $majors = [
            ['name' => 'Teknik Komputer dan Jaringan', 'code' => 'TKJ'],
            ['name' => 'Rekayasa Perangkat Lunak', 'code' => 'RPL'],
            ['name' => 'Multimedia', 'code' => 'MM'],
            ['name' => 'Teknik Elektronika Industri', 'code' => 'TEI'],
        ];

        $major = fake()->randomElement($majors);

        return [
            'name' => $major['name'],
            'code' => $major['code'],
            'description' => fake()->sentence(),
        ];
    }
}