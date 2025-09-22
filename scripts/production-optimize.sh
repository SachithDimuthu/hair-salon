#!/bin/bash

# Luxe Hair Studio - Production Optimization Script
# Run this script when deploying to production

echo "🚀 Starting Luxe Hair Studio production optimization..."

# Clear all caches first
echo "📝 Clearing existing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# Optimize Composer autoloader
echo "🎯 Optimizing Composer autoloader..."
composer install --optimize-autoloader --no-dev

# Cache configurations for better performance
echo "⚡ Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Create symbolic link for storage (if not exists)
echo "🔗 Creating storage symlink..."
php artisan storage:link

# Build optimized assets
echo "🎨 Building production assets..."
npm run build

# Optimize images (if imagemin is available)
if command -v imagemin &> /dev/null; then
    echo "🖼️ Optimizing images..."
    imagemin public/images/* --out-dir=public/images/
fi

# Set proper permissions
echo "🔒 Setting proper permissions..."
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs
chown -R www-data:www-data storage bootstrap/cache

# Database optimizations
echo "💾 Running database optimizations..."
php artisan migrate --force
php artisan db:seed --class=ProductionSeeder --force

# Queue optimization (if using queues)
echo "📋 Optimizing queues..."
php artisan queue:restart

# Generate sitemap (if applicable)
if php artisan list | grep -q "sitemap:generate"; then
    echo "🗺️ Generating sitemap..."
    php artisan sitemap:generate
fi

# Warm up application cache
echo "🔥 Warming up application cache..."
php artisan cache:warmup 2>/dev/null || echo "Cache warmup command not available"

# Final verification
echo "✅ Running final verification..."
php artisan about

echo "🎉 Production optimization completed successfully!"
echo ""
echo "📊 Performance Tips:"
echo "   - Monitor logs: tail -f storage/logs/laravel.log"
echo "   - Check queue status: php artisan queue:work --daemon"
echo "   - Monitor cache: php artisan cache:table"
echo ""
echo "🚀 Your Luxe Hair Studio application is ready for production!"