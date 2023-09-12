<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaraZeus\Wind\Models\Department;
use LaraZeus\Wind\WindPlugin;

class LetterFactory extends Factory
{
    public function getModel(): string
    {
        return WindPlugin::get()->getModel('Department');
    }

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'department_id' => Department::factory(),
            'title' => $this->faker->words(3, true),
            'message' => $this->faker->words(5, true),
            'status' => 'NEW',
        ];
    }
}
