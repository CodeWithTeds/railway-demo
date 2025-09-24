#!/bin/bash

set -euo pipefail

# Set PHP version for Railway deployment
export PHP_VERSION=8.1

# Change to the application directory (directory of this script), robust for spaces in path
SCRIPT_DIR="$(cd "$(dirname "$0")" && pwd)"
cd "$SCRIPT_DIR"

echo "=== Installing Composer Dependencies ==="
composer install --optimize-autoloader --no-dev --no-interaction --ignore-platform-reqs

echo "=== Installing NPM Dependencies ==="
npm ci

echo "=== Building Tailwind CSS ==="
# Build Tailwind CSS
npm run build

echo "=== Preparing Storage Directories ==="
mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache
chmod -R a+rw storage

# Generate APP_KEY if missing
if ! php -r "echo empty(env('APP_KEY')) ? 'missing' : 'ok';" | grep -q ok; then
  echo "=== Generating APP Key ==="
  php artisan key:generate --force
fi

echo "=== Optimizing Laravel ==="
php artisan config:clear
php artisan event:clear
php artisan route:clear
php artisan view:clear
php artisan optimize

echo "=== Running Database Migrations ==="
php artisan migrate:fresh --force || true
php artisan migrate --force || true

PORT_TO_USE=${PORT:-8000}
echo "=== Starting Laravel Server on port ${PORT_TO_USE} ==="
php artisan serve --host=0.0.0.0 --port="${PORT_TO_USE}"