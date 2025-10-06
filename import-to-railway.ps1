# Railway MongoDB Import Script
# This script imports your local MongoDB data to Railway

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Railway MongoDB Import Script" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$MONGO_URI = "mongodb://mongo:NHFMjojQXmtUGyxiCJxmeiwKGvAhVOBo@yamabiko.proxy.rlwy.net:40669/luxe_hair_catalog?authSource=admin"

# Check if mongoimport is installed
Write-Host "Checking for mongoimport..." -ForegroundColor Yellow
$mongoImport = Get-Command mongoimport -ErrorAction SilentlyContinue

if (-not $mongoImport) {
    Write-Host ""
    Write-Host "❌ mongoimport not found!" -ForegroundColor Red
    Write-Host ""
    Write-Host "OPTION 1: Install MongoDB Database Tools" -ForegroundColor Yellow
    Write-Host "Download from: https://www.mongodb.com/try/download/database-tools" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "OPTION 2: Use MongoDB Compass (GUI - Easier!)" -ForegroundColor Yellow
    Write-Host "1. Download MongoDB Compass: https://www.mongodb.com/try/download/compass" -ForegroundColor Cyan
    Write-Host "2. Connect using this URI:" -ForegroundColor Cyan
    Write-Host "   $MONGO_URI" -ForegroundColor White
    Write-Host "3. Create 'services' collection and import mongodb_services_export.json" -ForegroundColor Cyan
    Write-Host "4. Create 'deals' collection and import mongodb_deals_export.json" -ForegroundColor Cyan
    Write-Host ""
    exit 1
}

Write-Host "✅ mongoimport found: $($mongoImport.Source)" -ForegroundColor Green
Write-Host ""

# Import Services
Write-Host "Importing services..." -ForegroundColor Yellow
& mongoimport --uri="$MONGO_URI" --collection=services --file=mongodb_services_export.json --jsonArray --drop

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Services imported successfully!" -ForegroundColor Green
} else {
    Write-Host "❌ Services import failed!" -ForegroundColor Red
    exit 1
}

Write-Host ""

# Import Deals
Write-Host "Importing deals..." -ForegroundColor Yellow
& mongoimport --uri="$MONGO_URI" --collection=deals --file=mongodb_deals_export.json --jsonArray --drop

if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ Deals imported successfully!" -ForegroundColor Green
} else {
    Write-Host "❌ Deals import failed!" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "✅ IMPORT COMPLETE!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Yellow
Write-Host "1. Visit your Railway app: https://hair-salon-production.up.railway.app/" -ForegroundColor Cyan
Write-Host "2. Check that services are displaying" -ForegroundColor Cyan
Write-Host "3. Go to Railway MongoDB Data tab to verify collections" -ForegroundColor Cyan
Write-Host ""
