<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $categories = [
            'Fiksi', 'Non-Fiksi', 'Sains', 'Teknologi', 'Sejarah',
            'Biografi', 'Pendidikan', 'Agama', 'Ekonomi', 'Hukum',
            'Kesehatan', 'Seni', 'Olahraga', 'Masakan', 'Perjalanan',
        ];

        $name = fake()->unique()->randomElement($categories);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
        ];
    }
}
