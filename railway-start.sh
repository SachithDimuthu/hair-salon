#!/bin/bash

echo "🚀 Starting Luxe Hair Studio..."
echo "================================"

# Run migrations
echo "📄 Running database migrations..."
php artisan migrate --force

# Cache configuration only (no routes/views to avoid 404s)
echo "⚡ Caching configuration..."
php artisan config:cache

# Start server
echo "✅ Starting web server..."
php artisan serve --host=0.0.0.0 --port=$PORT
