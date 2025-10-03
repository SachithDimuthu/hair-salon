@echo off
echo 🚀 Starting Railway deployment process...

echo 📦 Installing PHP dependencies...
call composer install --optimize-autoloader --no-dev --verbose

echo 📦 Installing Node dependencies...
call npm ci

echo 🏗️  Building frontend assets...
call npm run build

echo 🧹 Clearing application caches...
call php artisan config:clear
call php artisan cache:clear
call php artisan view:clear
call php artisan route:clear

echo ✅ Deployment process completed successfully!