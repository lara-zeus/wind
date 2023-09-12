<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use LaraZeus\Wind\WindPlugin;

class DepartmentFactory extends Factory
{
    public function getModel(): string
    {
        return WindPlugin::get()->getModel('Department');
    }

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'ordering' => $this->faker->numberBetween(1, 10),
            'is_active' => $this->faker->numberBetween(0, 1),
            'desc' => $this->faker->words(5, true),
            'slug' => $this->faker->slug,
        ];
    }
}
