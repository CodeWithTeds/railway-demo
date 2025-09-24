#!/bin/bash

# Change to the application directory
cd /Applications/XAMPP/xamppfiles/htdocs/IMS\ copy/app

echo "=== Installing Composer Dependencies ==="
# Using --ignore-platform-reqs to bypass PHP version requirements
composer update --ignore-platform-reqs --no-interaction

echo "=== Installing NPM Dependencies ==="
npm install

echo "=== Running Database Migrations ==="
php artisan migrate --force

echo "=== Building Assets ==="
npm run build

echo "=== Starting Development Server ==="
npm run dev & php artisan serve --host=0.0.0.0 --port=8000