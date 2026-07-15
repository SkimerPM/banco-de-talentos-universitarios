<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Desarrollo Web',
            'Aplicaciones Moviles',
            'Inteligencia Artificial',
            'Internet de las Cosas',
            'Ciencia de Datos',
            'Ciberseguridad',
            'Videojuegos',
            'Realidad Virtual',
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }
    }
}
