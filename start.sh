#!/bin/bash

# Change to the application directory
cd /Applications/XAMPP/xamppfiles/htdocs/IMS\ copy/app

echo "=== Installing Composer Dependencies ==="
composer install --optimize-autoloader --no-dev --no-interaction --ignore-platform-reqs

echo "=== Installing NPM Dependencies ==="
npm ci

echo "=== Preparing Storage Directories ==="
mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache
chmod -R a+rw storage

echo "=== Optimizing Laravel ==="
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

echo "=== Running Database Migrations ==="
php artisan migrate --force

echo "=== Building Assets ==="
npm run build

echo "=== Starting Development Server ==="
php artisan serve --host=0.0.0.0 --port=8000