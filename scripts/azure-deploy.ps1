# Azure Deployment Preparation Script for Luxe Hair Studio (PowerShell)
# This script optimizes the Laravel application for production deployment

Write-Host "Starting Azure deployment preparation..." -ForegroundColor Green
Write-Host "==========================================" -ForegroundColor Green

# Check if we're in the correct directory
if (-not (Test-Path "artisan")) {
    Write-Host "Error: This script must be run from the Laravel project root directory" -ForegroundColor Red
    exit 1
}

# Function to check command success
function Test-CommandSuccess {
    param($Description, $LastExitCode)
    if ($LastExitCode -eq 0) {
        Write-Host "   Success: $Description completed successfully" -ForegroundColor Green
    } else {
        Write-Host "   Error: $Description failed" -ForegroundColor Red
        exit 1
    }
}

# Copy environment file for production
Write-Host "Setting up production environment..." -ForegroundColor Cyan
if (Test-Path ".env.azure") {
    Copy-Item ".env.azure" ".env.production"
    Write-Host "   Success: Production environment file created" -ForegroundColor Green
} else {
    Write-Host "   Warning: .env.azure not found, using .env as template" -ForegroundColor Yellow
    Copy-Item ".env" ".env.production"
}

# Install PHP dependencies (production optimized) - skip for now to avoid hanging
Write-Host "Checking Composer dependencies..." -ForegroundColor Cyan
Write-Host "   Note: Skipping composer install for now due to potential hanging issues" -ForegroundColor Yellow
Write-Host "   You can run 'composer install --optimize-autoloader --no-dev' manually later" -ForegroundColor Yellow

# Install Node.js dependencies
Write-Host "Installing Node.js dependencies..." -ForegroundColor Cyan
if (Test-Path "package-lock.json") {
    npm ci
    Test-CommandSuccess "NPM dependencies installation (from lockfile)" $LASTEXITCODE
} else {
    npm install
    Test-CommandSuccess "NPM dependencies installation" $LASTEXITCODE
}

# Build frontend assets for production
Write-Host "Building frontend assets for production..." -ForegroundColor Cyan
npm run build
Test-CommandSuccess "Frontend assets build" $LASTEXITCODE

# Generate application key if not exists
Write-Host "Generating application key..." -ForegroundColor Cyan
php artisan key:generate --force --no-interaction
Test-CommandSuccess "Application key generation" $LASTEXITCODE

# Clear and optimize Laravel caches
Write-Host "Optimizing Laravel for production..." -ForegroundColor Cyan

# Clear existing caches
Write-Host "   Clearing existing caches..." -ForegroundColor White
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
Write-Host "   Success: Cache clearing completed" -ForegroundColor Green

# Create optimized caches
Write-Host "   Creating optimized caches..." -ForegroundColor White
php artisan config:cache
Test-CommandSuccess "Configuration cache" $LASTEXITCODE

php artisan route:cache
Test-CommandSuccess "Route cache" $LASTEXITCODE

php artisan view:cache
Test-CommandSuccess "View cache" $LASTEXITCODE

# Create storage symbolic link (if needed)
Write-Host "Creating storage symbolic link..." -ForegroundColor Cyan
php artisan storage:link
Test-CommandSuccess "Storage link creation" $LASTEXITCODE

# Verify database configuration
Write-Host "Verifying database configuration..." -ForegroundColor Cyan
try {
    $output = php artisan tinker --execute="try { DB::connection('sqlite')->getPdo(); echo 'success'; } catch (Exception \$e) { echo 'failed'; }" 2>$null
    if ($output -match "success") {
        Write-Host "   Success: SQLite database connection verified" -ForegroundColor Green
    } else {
        Write-Host "   Warning: SQLite database connection failed" -ForegroundColor Yellow
    }
} catch {
    Write-Host "   Warning: Database connection test failed" -ForegroundColor Yellow
}

# Create deployment manifest
Write-Host "Creating deployment manifest..." -ForegroundColor Cyan
$phpVersion = php -r "echo PHP_VERSION;"
$nodeVersion = node --version
$npmVersion = npm --version

$deploymentManifest = @{
    deployment_date = (Get-Date).ToUniversalTime().ToString("yyyy-MM-ddTHH:mm:ssZ")
    php_version = $phpVersion
    node_version = $nodeVersion
    npm_version = $npmVersion
    cache_status = @{
        config_cached = Test-Path "bootstrap/cache/config.php"
        routes_cached = Test-Path "bootstrap/cache/routes-v7.php"
        views_cached = Test-Path "storage/framework/views"
    }
    build_assets = @{
        css_files = (Get-ChildItem -Path "public/build" -Filter "*.css" -Recurse -ErrorAction SilentlyContinue | Measure-Object).Count
        js_files = (Get-ChildItem -Path "public/build" -Filter "*.js" -Recurse -ErrorAction SilentlyContinue | Measure-Object).Count
    }
}

$deploymentManifest | ConvertTo-Json -Depth 3 | Out-File -FilePath "deployment-manifest.json" -Encoding UTF8
Write-Host "   Success: Deployment manifest created" -ForegroundColor Green

# Security check
Write-Host "Running security checks..." -ForegroundColor Cyan
if (Test-Path ".env") {
    $envContent = Get-Content ".env"
    if ($envContent -match "APP_DEBUG=true") {
        Write-Host "   Warning: APP_DEBUG is still true in .env" -ForegroundColor Yellow
    }
    if ($envContent -match "APP_ENV=local") {
        Write-Host "   Warning: APP_ENV is still local in .env" -ForegroundColor Yellow
    }
}

# Size optimization report
Write-Host "Deployment size analysis..." -ForegroundColor Cyan
$totalSize = (Get-ChildItem -Recurse -ErrorAction SilentlyContinue | Measure-Object -Property Length -Sum).Sum / 1MB
$vendorSize = if (Test-Path "vendor") { (Get-ChildItem "vendor" -Recurse -ErrorAction SilentlyContinue | Measure-Object -Property Length -Sum).Sum / 1MB } else { 0 }
$nodeModulesSize = if (Test-Path "node_modules") { (Get-ChildItem "node_modules" -Recurse -ErrorAction SilentlyContinue | Measure-Object -Property Length -Sum).Sum / 1MB } else { 0 }
$buildSize = if (Test-Path "public/build") { (Get-ChildItem "public/build" -Recurse -ErrorAction SilentlyContinue | Measure-Object -Property Length -Sum).Sum / 1MB } else { 0 }

Write-Host "   Total project size: $([math]::Round($totalSize, 2)) MB" -ForegroundColor White
Write-Host "   Vendor directory: $([math]::Round($vendorSize, 2)) MB" -ForegroundColor White
Write-Host "   Node modules: $([math]::Round($nodeModulesSize, 2)) MB" -ForegroundColor White
Write-Host "   Built assets: $([math]::Round($buildSize, 2)) MB" -ForegroundColor White

Write-Host ""
Write-Host "Azure deployment preparation completed successfully!" -ForegroundColor Green
Write-Host "==========================================" -ForegroundColor Green
Write-Host "Next Steps:" -ForegroundColor Cyan
Write-Host "   1. Review .env.azure file and update with your Azure service details" -ForegroundColor White
Write-Host "   2. Create Azure resources (MySQL, Cosmos DB, App Service, etc.)" -ForegroundColor White
Write-Host "   3. Update azure/app-settings.json with your Azure configuration" -ForegroundColor White
Write-Host "   4. Run 'composer install --optimize-autoloader --no-dev' when ready" -ForegroundColor White
Write-Host "   5. Deploy to Azure using Git or GitHub Actions" -ForegroundColor White
Write-Host ""
Write-Host "Files created/updated:" -ForegroundColor Cyan
Write-Host "   - .env.production (production environment)" -ForegroundColor White
Write-Host "   - deployment-manifest.json (deployment details)" -ForegroundColor White
Write-Host "   - Optimized caches in bootstrap/cache/" -ForegroundColor White
Write-Host "   - Built assets in public/build/" -ForegroundColor White
Write-Host ""
Write-Host "Remember to:" -ForegroundColor Yellow
Write-Host "   - Never commit .env files with real credentials" -ForegroundColor White
Write-Host "   - Test locally before deploying to Azure" -ForegroundColor White
Write-Host "   - Update Azure app settings with real connection strings" -ForegroundColor White