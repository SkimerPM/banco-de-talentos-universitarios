<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'name' => 'Carlos Rodriguez',
                'email' => 'carlos.rodriguez@universidad.edu',
                'university' => 'Universidad Nacional',
                'career' => 'Ingenieria de Sistemas',
            ],
            [
                'name' => 'Maria Fernandez',
                'email' => 'maria.fernandez@universidad.edu',
                'university' => 'Universidad de los Andes',
                'career' => 'Ingenieria de Software',
            ],
            [
                'name' => 'Andres Lopez',
                'email' => 'andres.lopez@universidad.edu',
                'university' => 'Universidad del Valle',
                'career' => 'Ciencia de la Computacion',
            ],
            [
                'name' => 'Laura Martinez',
                'email' => 'laura.martinez@universidad.edu',
                'university' => 'Universidad Nacional',
                'career' => 'Ingenieria Electronica',
            ],
            [
                'name' => 'Juan Perez',
                'email' => 'juan.perez@universidad.edu',
                'university' => 'Universidad Javeriana',
                'career' => 'Ingenieria de Sistemas',
            ],
            [
                'name' => 'Sofia Garcia',
                'email' => 'sofia.garcia@universidad.edu',
                'university' => 'Universidad de Antioquia',
                'career' => 'Ingenieria de Software',
            ],
            [
                'name' => 'Diego Hernandez',
                'email' => 'diego.hernandez@universidad.edu',
                'university' => 'Universidad del Rosario',
                'career' => 'Ciencia de Datos',
            ],
            [
                'name' => 'Valentina Torres',
                'email' => 'valentina.torres@universidad.edu',
                'university' => 'Universidad de los Andes',
                'career' => 'Diseno Interactivo',
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
