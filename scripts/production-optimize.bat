@echo off
REM Luxe Hair Studio - Production Optimization Script for Windows
REM Run this script when deploying to production on Windows

echo 🚀 Starting Luxe Hair Studio production optimization...

REM Clear all caches first
echo 📝 Clearing existing caches...
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

REM Optimize Composer autoloader
echo 🎯 Optimizing Composer autoloader...
composer install --optimize-autoloader --no-dev

REM Cache configurations for better performance
echo ⚡ Caching configurations...
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

REM Create symbolic link for storage (if not exists)
echo 🔗 Creating storage symlink...
php artisan storage:link

REM Build optimized assets
echo 🎨 Building production assets...
npm run build

REM Database optimizations
echo 💾 Running database optimizations...
php artisan migrate --force

REM Queue optimization (if using queues)
echo 📋 Optimizing queues...
php artisan queue:restart

REM Final verification
echo ✅ Running final verification...
php artisan about

echo 🎉 Production optimization completed successfully!
echo.
echo 📊 Performance Tips:
echo    - Monitor logs in storage/logs/laravel.log
echo    - Check queue status with: php artisan queue:work
echo    - Monitor cache with: php artisan cache:table
echo.
echo 🚀 Your Luxe Hair Studio application is ready for production!

pause