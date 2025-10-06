#!/bin/bash

echo "🚀 Starting Luxe Hair Studio..."
echo "================================"

# Run migrations
echo "📄 Running database migrations..."
php artisan migrate --force

# Seed MongoDB with services
echo "🌱 Seeding MongoDB with services..."
php artisan db:seed --class=MongoDBServicesSeeder --force

# Cache configuration
echo "⚡ Caching configuration..."
php artisan config:cache
php artisan route:cache  
php artisan view:cache

# Start server
echo "✅ Starting web server..."
php artisan serve --host=0.0.0.0 --port=$PORT
