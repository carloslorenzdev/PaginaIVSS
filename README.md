## Página IVSS

Este es el código fuente del portal web del Instituto Venezolano de los Seguros Sociales (IVSS).

## Requerimientos

- PHP 8.2 o superior (Recomendado 8.4)
- Node.js 20 o superior
- Base de datos (PostgreSQL)
- Servidor en caché (Redis)
- Composer

## Instalación y Configuración

1. Clonar el repositorio

2. Instalar y configurar Redis (Requerido en Linux/Debian):
```bash
sudo apt update
sudo apt install redis-server php-redis
sudo systemctl enable redis-server
sudo systemctl start redis-server
```

3. Copiar el archivo de configuración de ejemplo:
```bash
cp .env.example .env
```

4. Abrir el archivo `.env` y configurar las variables de entorno, prestando especial atención a la base de datos y a Redis:
```ini
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=pagina_ivss
DB_USERNAME=postgres
DB_PASSWORD=

# Configuración de Redis
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Uso de Redis en el sistema
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

5. Instalar las dependencias de PHP (Composer):
```bash
composer install --optimize-autoloader --no-dev
```

6. Instalar las dependencias de Frontend (Node.js) y compilar los recursos (CSS/JS):
```bash
npm ci
npm run build
```

7. Generar la clave única de la aplicación y crear los enlaces simbólicos de almacenamiento:
```bash
php artisan key:generate
php artisan storage:link
```

8. Configurar permisos de directorios (Importante en servidores Linux/Debian):
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

9. Ejecutar las migraciones y seeders para estructurar y poblar la base de datos inicial:
```bash
php artisan migrate --seed
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=ChatbotConocimientoSeeder
php artisan db:seed --class=DirectoriosSeeder
```

10. (Opcional - Recomendado en Producción) Optimizar la caché general del sistema:
```bash
php artisan optimize:clear
```

## Ejecución en entorno local (Desarrollo)
Si se desea correr el proyecto en una computadora local de forma rápida, utilizar el servidor de desarrollo de Laravel:
```bash
php artisan serve
```