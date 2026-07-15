# Banco de Talentos Universitario

Aplicacion web para registrar proyectos desarrollados por estudiantes universitarios y permitir que empresas consulten dichos proyectos.

## Tecnologias

- **Backend:** Laravel (PHP 8.5)
- **Frontend:** Vue 3 + Inertia.js
- **Estilos:** Tailwind CSS
- **Base de datos:** SQLite
- **Iconos:** Lucide

## Requisitos previos

- PHP 8.2 o superior
- Composer
- Node.js 18 o superior
- NPM
- Extensiones PHP: pdo_sqlite, sqlite3, fileinfo, gd

## Instalacion local

Descomprimir el archivo ZIP del proyecto y abrir una terminal en la carpeta resultante.

Instalar dependencias:

```bash
composer install
npm install
```

Configurar entorno:

```bash
cp .env.example .env
php artisan key:generate
```

Crear base de datos y ejecutar migraciones con datos de ejemplo:

```bash
touch database/database.sqlite
php artisan migrate
php artisan db:seed
```

Crear enlace simbolico para imagenes:

```bash
php artisan storage:link
```

## Ejecucion

Iniciar el servidor de desarrollo:

```bash
php artisan serve
```

En otra terminal, compilar assets en modo desarrollo:

```bash
npm run dev
```

La aplicacion estara disponible en: http://localhost:8000

## Estructura de la base de datos

La aplicacion utiliza 3 tablas relacionadas:

- **students** - Estudiantes registrados
- **categories** - Categorias de proyectos
- **projects** - Proyectos (pertenece a un estudiante y a una categoria)

Relaciones:
- Un estudiante tiene muchos proyectos
- Una categoria tiene muchos proyectos
- Un proyecto pertenece a un estudiante y a una categoria

## Funcionalidades

- CRUD completo de estudiantes y proyectos
- Subida y visualizacion de imagenes
- Validaciones de formularios en servidor
- Busqueda dinamica con filtros por categoria, estado y tecnologia
- Dashboard de estadisticas (proyectos por estado, por categoria, top tecnologias, top estudiantes)

## Compilar para produccion

```bash
npm run build
```

## Enlace de produccion

https://manuel6363.alwaysdata.net
