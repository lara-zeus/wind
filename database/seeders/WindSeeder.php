<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use LaraZeus\Wind\Models\Department;
use LaraZeus\Wind\Models\Letter;

class WindSeeder extends Seeder
{
    public function run()
    {
        Department::factory()->has(
            Letter::factory()
                ->count(5)
                ->state(function (array $attributes, Department $department) {
                    return [
                        'department_id' => $department->id,
                    ];
                })
        )->count(3)->create();
    }
}
