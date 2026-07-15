<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Sistema de Gestion Academica',
                'description' => 'Plataforma web para la gestion integral de procesos academicos universitarios, incluyendo matriculas, calificaciones y horarios.',
                'student_id' => 1,
                'category_id' => 1,
                'status' => 'completed',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Tailwind CSS'],
                'repository_url' => 'https://github.com/ejemplo/gestion-academica',
            ],
            [
                'title' => 'App de Transporte Universitario',
                'description' => 'Aplicacion movil que permite a los estudiantes rastrear las rutas de buses universitarios en tiempo real y planificar sus viajes.',
                'student_id' => 2,
                'category_id' => 2,
                'status' => 'published',
                'technologies' => ['Flutter', 'Firebase', 'Google Maps API', 'Node.js'],
                'repository_url' => 'https://github.com/ejemplo/transporte-uni',
                'demo_url' => 'https://transporte-uni.demo.com',
            ],
            [
                'title' => 'Chatbot de Asistencia Estudiantil',
                'description' => 'Asistente virtual basado en inteligencia artificial que responde preguntas frecuentes de estudiantes sobre tramites y servicios universitarios.',
                'student_id' => 3,
                'category_id' => 3,
                'status' => 'completed',
                'technologies' => ['Python', 'TensorFlow', 'FastAPI', 'React'],
            ],
            [
                'title' => 'Sistema de Riego Inteligente',
                'description' => 'Dispositivo IoT que monitorea la humedad del suelo y automatiza el riego de jardines universitarios, reduciendo el consumo de agua en un 40%.',
                'student_id' => 4,
                'category_id' => 4,
                'status' => 'published',
                'technologies' => ['Arduino', 'ESP32', 'MQTT', 'React Native'],
                'demo_url' => 'https://riego-smart.demo.com',
            ],
            [
                'title' => 'Analisis Predictivo de Desercion',
                'description' => 'Modelo de machine learning que predice la probabilidad de desercion estudiantil basandose en datos academicos y socioeconomicos.',
                'student_id' => 7,
                'category_id' => 5,
                'status' => 'completed',
                'technologies' => ['Python', 'Scikit-learn', 'Pandas', 'Streamlit'],
                'repository_url' => 'https://github.com/ejemplo/desercion-ml',
            ],
            [
                'title' => 'Plataforma de Seguridad de Red',
                'description' => 'Herramienta de monitoreo y analisis de trafico de red que detecta amenazas y vulnerabilidades en infraestructuras universitarias.',
                'student_id' => 5,
                'category_id' => 6,
                'status' => 'in_progress',
                'technologies' => ['Python', 'Wireshark', 'Docker', 'Elasticsearch'],
            ],
            [
                'title' => 'Juego Educativo de Matematicas',
                'description' => 'Videojuego 2D para dispositivos moviles que gamifica el aprendizaje de calculo diferencial para estudiantes de primer semestre.',
                'student_id' => 8,
                'category_id' => 7,
                'status' => 'published',
                'technologies' => ['Unity', 'C#', 'Firebase', 'Photoshop'],
                'demo_url' => 'https://math-game.demo.com',
            ],
            [
                'title' => 'Recorrido Virtual del Campus',
                'description' => 'Experiencia inmersiva en realidad virtual que permite a aspirantes conocer las instalaciones universitarias de forma remota.',
                'student_id' => 8,
                'category_id' => 8,
                'status' => 'completed',
                'technologies' => ['Unity', 'Blender', 'Oculus SDK', 'C#'],
                'repository_url' => 'https://github.com/ejemplo/campus-vr',
            ],
            [
                'title' => 'E-commerce para Emprendedores',
                'description' => 'Marketplace universitario donde estudiantes emprendedores pueden vender sus productos y servicios a la comunidad academica.',
                'student_id' => 6,
                'category_id' => 1,
                'status' => 'published',
                'technologies' => ['Next.js', 'Stripe', 'PostgreSQL', 'Tailwind CSS'],
                'repository_url' => 'https://github.com/ejemplo/uni-market',
                'demo_url' => 'https://uni-market.demo.com',
            ],
            [
                'title' => 'Detector de Plagio con IA',
                'description' => 'Sistema que utiliza procesamiento de lenguaje natural para detectar similitudes entre documentos academicos y prevenir el plagio.',
                'student_id' => 3,
                'category_id' => 3,
                'status' => 'in_progress',
                'technologies' => ['Python', 'NLTK', 'SpaCy', 'Django'],
            ],
            [
                'title' => 'App de Salud Mental Estudiantil',
                'description' => 'Aplicacion que ofrece recursos de bienestar mental, meditaciones guiadas y seguimiento del estado emocional para estudiantes universitarios.',
                'student_id' => 2,
                'category_id' => 2,
                'status' => 'completed',
                'technologies' => ['React Native', 'Node.js', 'MongoDB', 'Socket.io'],
                'repository_url' => 'https://github.com/ejemplo/mental-health-app',
            ],
            [
                'title' => 'Dashboard de Indicadores Academicos',
                'description' => 'Panel interactivo que visualiza indicadores clave de rendimiento academico a nivel de facultad utilizando datos historicos.',
                'student_id' => 7,
                'category_id' => 5,
                'status' => 'published',
                'technologies' => ['D3.js', 'Python', 'Flask', 'PostgreSQL'],
                'demo_url' => 'https://dashboard-academico.demo.com',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
