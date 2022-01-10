<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use LaraZeus\Wind\Models\Category;
use LaraZeus\Wind\Models\Letter;

class WindSeeder extends Seeder
{
    public function run()
    {
        Category::factory()->has(
            Letter::factory()
                ->count(5)
                ->state(function (array $attributes, Category $category) {
                    return [
                        'category_id' => $category->id,
                    ];
                })
        )->count(3)->create();
    }
}
