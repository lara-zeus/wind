<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaraZeus\Wind\Models\Category;
use LaraZeus\Wind\Models\Letter;

class LetterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Letter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \JsonException
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'category_id' => Category::factory(),
            'title' => $this->faker->words(3, true),
            'message' => $this->faker->words(5, true),
            'status' => 'NEW',
        ];
    }
}