#!/bin/bash

echo "🚀 Starting Railway build process..."

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --optimize-autoloader --no-dev --verbose

# Install Node dependencies
echo "📦 Installing Node dependencies..."
npm ci

# Build frontend assets
echo "🏗️  Building frontend assets..."
npm run build

# Clear Laravel caches
echo "🧹 Clearing application caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "✅ Build process completed successfully!"