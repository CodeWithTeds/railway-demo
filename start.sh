#!/bin/bash

# Change to the application directory
cd /Applications/XAMPP/xamppfiles/htdocs/IMS\ copy/app

echo "=== Installing Composer Dependencies ==="
composer install

echo "=== Installing NPM Dependencies ==="
npm install

echo "=== Running Database Migrations ==="
php artisan migrate

echo "=== Building Assets ==="
npm run build

echo "=== Starting Development Server ==="
npm run dev & php artisan serve --host=0.0.0.0 --port=8000