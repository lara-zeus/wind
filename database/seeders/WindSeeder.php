<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use LaraZeus\Wind\Models\Department;
use LaraZeus\Wind\WindPlugin;

class WindSeeder extends Seeder
{
    public function run(): void
    {
        WindPlugin::get()->getModel('Department')::factory()
            ->has(
                WindPlugin::get()->getModel('Letter')::factory()
                    ->count(5)
                    ->state(function (array $attributes, Department $department) {
                        return [
                            'department_id' => $department->id,
                        ];
                    })
            )->count(3)->create();
    }
}
