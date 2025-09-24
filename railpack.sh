#!/bin/bash

# Railpack deployment script
# This script is specifically designed to work with Railpack deployment

echo "=== Railpack Deployment Script ==="

# Copy Railway environment file
echo "=== Setting up Environment ==="
if [ -f .env.railway ]; then
    cp .env.railway .env
    echo "Using Railway environment configuration"
fi

# Install composer dependencies with downgraded requirements
echo "=== Installing Composer Dependencies ==="
composer install --optimize-autoloader --no-scripts --no-interaction

# Install NPM dependencies
echo "=== Installing NPM Dependencies ==="
npm ci

# Prepare storage directories
echo "=== Preparing Storage Directories ==="
mkdir -p storage/framework/{sessions,views,cache,testing} storage/logs bootstrap/cache
chmod -R a+rw storage

# Generate application key if not set
php artisan key:generate --force

# Wait for database to be ready
echo "=== Waiting for Database Connection ==="
MAX_RETRIES=30
RETRY_COUNT=0

while [ $RETRY_COUNT -lt $MAX_RETRIES ]; do
    echo "Attempting to connect to database (attempt $((RETRY_COUNT+1))/$MAX_RETRIES)..."
    php artisan-db-monitor > /dev/null 2>&1
    if [ $? -eq 0 ]; then
        echo "Database connection successful!"
        break
    fi
    RETRY_COUNT=$((RETRY_COUNT+1))
    echo "Database not ready yet. Retrying in 5 seconds..."
    sleep 5
done

if [ $RETRY_COUNT -eq $MAX_RETRIES ]; then
    echo "Failed to connect to database after $MAX_RETRIES attempts."
    echo "Please check your database configuration and ensure the database service is running."
    exit 1
fi

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