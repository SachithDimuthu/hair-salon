#!/bin/bash
set -e

echo ""
echo "========================================"
echo "🚀 RAILWAY POST-DEPLOY SCRIPT STARTING"
echo "========================================"
echo "Timestamp: $(date)"
echo "PWD: $(pwd)"
echo "PHP Version: $(php -v | head -n 1)"
echo "========================================"

echo ""
echo "📋 Running migrations..."
php artisan migrate --force
echo "✅ Migrations complete"

echo ""
echo "========================================"
echo "🌱 RUNNING MONGODB SEEDER"
echo "========================================"
php artisan db:seed --class=MongoDBServicesSeeder --force
echo "✅ Seeder complete"

echo ""
echo "📦 Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Cache complete"

echo ""
echo "========================================"
echo "✅ POST-DEPLOY COMPLETE!"
echo "========================================"
echo ""
