#!/bin/bash

# Railpack deployment script
# This script is specifically designed to work with Railpack deployment

echo "=== Railpack Deployment Script ==="

# Update composer dependencies with platform requirements ignored
echo "=== Updating Composer Dependencies ==="
composer update --no-dev --ignore-platform-reqs --optimize-autoloader --no-scripts --no-interaction

# Install NPM dependencies
echo "=== Installing NPM Dependencies ==="
npm ci

# Prepare storage directories
echo "=== Preparing Storage Directories ==="
mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache
chmod -R a+rw storage

# Optimize Laravel
echo "=== Optimizing Laravel ==="
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
echo "=== Running Database Migrations ==="
php artisan migrate --force

# Build assets
echo "=== Building Assets ==="
npm run build

echo "=== Railpack Deployment Complete ==="