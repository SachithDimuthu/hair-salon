#!/bin/bash
# Azure Deployment Preparation Script for Luxe Hair Studio
# This script optimizes the Laravel application for production deployment

echo "🚀 Starting Azure deployment preparation..."
echo "=========================================="

# Check if we're in the correct directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: This script must be run from the Laravel project root directory"
    exit 1
fi

# Function to check command success
check_command() {
    if [ $? -eq 0 ]; then
        echo "   ✅ $1 completed successfully"
    else
        echo "   ❌ $1 failed"
        exit 1
    fi
}

# Copy environment file for production
echo "📝 Setting up production environment..."
if [ -f ".env.azure" ]; then
    cp .env.azure .env.production
    check_command "Production environment file created"
else
    echo "   ⚠️  Warning: .env.azure not found, using .env as template"
    cp .env .env.production
fi

# Install PHP dependencies (production optimized)
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction --prefer-dist
check_command "Composer dependencies installation"

# Install Node.js dependencies
echo "📦 Installing Node.js dependencies..."
if [ -f "package-lock.json" ]; then
    npm ci --production
    check_command "NPM dependencies installation (from lockfile)"
else
    npm install --production
    check_command "NPM dependencies installation"
fi

# Build frontend assets for production
echo "🎨 Building frontend assets for production..."
npm run build
check_command "Frontend assets build"

# Generate application key if not exists
echo "🔑 Generating application key..."
php artisan key:generate --force --no-interaction
check_command "Application key generation"

# Clear and optimize Laravel caches
echo "⚡ Optimizing Laravel for production..."

# Clear existing caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
check_command "Cache clearing"

# Create optimized caches
php artisan config:cache
check_command "Configuration cache"

php artisan route:cache
check_command "Route cache"

php artisan view:cache
check_command "View cache"

php artisan event:cache
check_command "Event cache"

# Optimize Composer autoloader
echo "🔧 Optimizing Composer autoloader..."
composer dump-autoload --optimize --no-dev
check_command "Autoloader optimization"

# Create storage symbolic link (if needed)
echo "🔗 Creating storage symbolic link..."
php artisan storage:link
check_command "Storage link creation"

# Verify database configuration
echo "🗄️  Verifying database configuration..."
if php artisan tinker --execute="DB::connection()->getPdo(); echo 'Database connection successful';" 2>/dev/null; then
    echo "   ✅ Primary database connection verified"
else
    echo "   ⚠️  Warning: Primary database connection failed (normal if Azure services not yet created)"
fi

# Test MongoDB configuration (if available)
if php artisan tinker --execute="DB::connection('mongodb')->getCollection('test'); echo 'MongoDB connection successful';" 2>/dev/null; then
    echo "   ✅ MongoDB connection verified"
else
    echo "   ⚠️  Warning: MongoDB connection failed (normal if Azure Cosmos DB not yet created)"
fi

# Check file permissions (Linux/macOS)
if [[ "$OSTYPE" == "linux-gnu"* ]] || [[ "$OSTYPE" == "darwin"* ]]; then
    echo "🔒 Setting file permissions..."
    chmod -R 755 storage bootstrap/cache
    check_command "File permissions set"
fi

# Create deployment manifest
echo "📋 Creating deployment manifest..."
cat > deployment-manifest.json << EOF
{
    "deployment_date": "$(date -u +%Y-%m-%dT%H:%M:%SZ)",
    "php_version": "$(php -r 'echo PHP_VERSION;')",
    "laravel_version": "$(php artisan --version | grep -oE '[0-9]+\.[0-9]+\.[0-9]+')",
    "node_version": "$(node --version)",
    "npm_version": "$(npm --version)",
    "composer_packages": $(composer show --format=json | jq '.installed | length'),
    "npm_packages": $(npm list --json 2>/dev/null | jq '.dependencies | length // 0'),
    "build_assets": {
        "css_files": $(find public/build -name "*.css" 2>/dev/null | wc -l),
        "js_files": $(find public/build -name "*.js" 2>/dev/null | wc -l)
    },
    "cache_status": {
        "config_cached": $([ -f bootstrap/cache/config.php ] && echo true || echo false),
        "routes_cached": $([ -f bootstrap/cache/routes-v7.php ] && echo true || echo false),
        "views_cached": $([ -d storage/framework/views ] && echo true || echo false)
    }
}
EOF
check_command "Deployment manifest created"

# Security check
echo "🔒 Running security checks..."
if [ -f ".env" ]; then
    if grep -q "APP_DEBUG=true" .env; then
        echo "   ⚠️  Warning: APP_DEBUG is still true in .env"
    fi
    if grep -q "APP_ENV=local" .env; then
        echo "   ⚠️  Warning: APP_ENV is still local in .env"
    fi
fi

# Size optimization report
echo "📊 Deployment size analysis..."
echo "   📁 Total project size: $(du -sh . | cut -f1)"
echo "   📁 Vendor directory: $(du -sh vendor | cut -f1)"
echo "   📁 Node modules: $(du -sh node_modules 2>/dev/null | cut -f1 || echo 'Not found')"
echo "   📁 Built assets: $(du -sh public/build 2>/dev/null | cut -f1 || echo 'Not found')"

echo ""
echo "✅ Azure deployment preparation completed successfully!"
echo "=========================================="
echo "📋 Next Steps:"
echo "   1. Review .env.azure file and update with your Azure service details"
echo "   2. Create Azure resources (MySQL, Cosmos DB, App Service, etc.)"
echo "   3. Update azure/app-settings.json with your Azure configuration"
echo "   4. Deploy to Azure using Git or GitHub Actions"
echo ""
echo "🔍 Files created/updated:"
echo "   - .env.production (production environment)"
echo "   - deployment-manifest.json (deployment details)"
echo "   - Optimized caches in bootstrap/cache/"
echo "   - Built assets in public/build/"
echo ""
echo "⚠️  Remember to:"
echo "   - Never commit .env files with real credentials"
echo "   - Test locally before deploying to Azure"
echo "   - Update Azure app settings with real connection strings"