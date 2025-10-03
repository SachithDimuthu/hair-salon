#!/bin/bash

echo "🚀 Post-deployment setup for Railway..."

# Run database migrations
echo "📄 Running database migrations..."
php artisan migrate --force

# Seed basic data if needed
echo "🌱 Seeding basic data..."
php artisan db:seed --class=BasicDataSeeder --force

# Create storage symlink
echo "🔗 Creating storage symlink..."
php artisan storage:link

# Clear and cache everything
echo "🧹 Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Set proper permissions
echo "🔒 Setting proper permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "✅ Post-deployment setup completed!"