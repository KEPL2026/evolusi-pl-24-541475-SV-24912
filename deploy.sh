#!/usr/bin/env bash
set -e

echo "=== [Deploy Script] Starting deployment ==="

# Navigate to project directory
if [ -n "$GITHUB_WORKSPACE" ]; then
    cd "$GITHUB_WORKSPACE"
fi

echo "Current working directory: $(pwd)"

# 1. Install dependencies
echo "--> Installing composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# 2. Run migrations
echo "--> Running database migrations..."
php artisan migrate --force

# 3. Cache config and routes for production
echo "--> Caching configuration and routes..."
php artisan config:cache
php artisan route:cache

echo "=== [Deploy Script] Deployment completed successfully! ==="
