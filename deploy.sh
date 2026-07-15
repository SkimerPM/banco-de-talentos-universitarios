#!/bin/bash

set -e

echo "Instalando dependencias PHP..."
composer install --no-dev --optimize-autoloader

echo "Instalando dependencias Node..."
npm ci

echo "Compilando assets..."
npm run build

echo "Configurando entorno..."
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate
fi

echo "Creando base de datos..."
touch database/database.sqlite

echo "Ejecutando migraciones..."
php artisan migrate --force

echo "Ejecutando seeders..."
php artisan db:seed --force

echo "Creando enlace de storage..."
php artisan storage:link 2>/dev/null || true

echo "Optimizando..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Despliegue completado."
