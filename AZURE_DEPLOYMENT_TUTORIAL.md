# Azure Deployment Tutorial for Luxe Hair Studio

## 🎯 Overview

This tutorial will guide you through deploying your Laravel-based hair salon booking system to Microsoft Azure. The application uses a hybrid database architecture with MySQL for relational data and MongoDB for catalog management.

## 🏗️ Application Architecture

**Technology Stack:**
- **Backend**: Laravel 12 with PHP 8.2
- **Frontend**: Livewire + Alpine.js + Tailwind CSS
- **Database**: MySQL (relational data) + MongoDB (services/deals catalog)
- **Authentication**: Laravel Sanctum + Jetstream
- **Build Tool**: Vite

## 📋 Prerequisites

Before starting, ensure you have:

1. **Azure Account**: [Create free account](https://azure.microsoft.com/free/)
2. **Azure CLI**: [Install Azure CLI](https://docs.microsoft.com/en-us/cli/azure/install-azure-cli)
3. **Git**: For version control
4. **Basic Azure Knowledge**: Understanding of Azure services

## 🚀 Step 1: Prepare Your Application for Production

### 1.1 Update Environment Configuration

Create a production environment file:

```bash
# Copy existing .env to .env.azure
cp .env .env.azure
```

Update `.env.azure` with production settings:

```env
# Application Settings
APP_NAME="Luxe Hair Studio"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.azurewebsites.net

# Generate a new key for production
APP_KEY=base64:YOUR_NEW_PRODUCTION_KEY

# Database - MySQL (Azure Database for MySQL)
DB_CONNECTION=mysql
DB_HOST=your-mysql-server.mysql.database.azure.com
DB_PORT=3306
DB_DATABASE=luxe_hair_studio
DB_USERNAME=your_username@your-mysql-server
DB_PASSWORD=your_secure_password

# MongoDB (Azure Cosmos DB with MongoDB API)
DB_MONGO_HOST=your-cosmosdb-account.mongo.cosmos.azure.com
DB_MONGO_PORT=10255
DB_MONGO_DATABASE=luxe_hair_studio
DB_MONGO_USERNAME=your-cosmosdb-account
DB_MONGO_PASSWORD=your_primary_key

# Cache & Sessions (Azure Redis Cache)
CACHE_DRIVER=redis
SESSION_DRIVER=redis
REDIS_HOST=your-redis-cache.redis.cache.windows.net
REDIS_PASSWORD=your_redis_key
REDIS_PORT=6380
REDIS_CLIENT=phpredis

# Mail (Azure Communication Services or SendGrid)
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your_sendgrid_api_key
MAIL_ENCRYPTION=tls

# File Storage (Azure Blob Storage)
FILESYSTEM_DISK=azure
AZURE_STORAGE_ACCOUNT_NAME=your_storage_account
AZURE_STORAGE_ACCOUNT_KEY=your_storage_key
AZURE_STORAGE_CONTAINER=salon-uploads
```

### 1.2 Optimize for Production

Create `scripts/azure-deploy.sh`:

```bash
#!/bin/bash
echo "🚀 Starting Azure deployment preparation..."

# Install dependencies
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

# Install Node dependencies and build assets
echo "🎨 Building frontend assets..."
npm ci --production
npm run build

# Optimize Laravel
echo "⚡ Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Generate application key if needed
php artisan key:generate --force

echo "✅ Deployment preparation complete!"
```

Make it executable:
```bash
chmod +x scripts/azure-deploy.sh
```

### 1.3 Create Azure-specific Configuration

Create `azure/app-settings.json`:

```json
{
  "APP_ENV": "production",
  "APP_DEBUG": "false",
  "APP_KEY": "base64:YOUR_PRODUCTION_KEY",
  "APP_URL": "https://your-app-name.azurewebsites.net",
  "DB_CONNECTION": "mysql",
  "DB_HOST": "your-mysql-server.mysql.database.azure.com",
  "DB_PORT": "3306",
  "DB_DATABASE": "luxe_hair_studio",
  "DB_USERNAME": "your_username@your-mysql-server",
  "DB_PASSWORD": "your_secure_password",
  "DB_MONGO_HOST": "your-cosmosdb-account.mongo.cosmos.azure.com",
  "DB_MONGO_PORT": "10255",
  "DB_MONGO_DATABASE": "luxe_hair_studio",
  "DB_MONGO_USERNAME": "your-cosmosdb-account",
  "DB_MONGO_PASSWORD": "your_primary_key",
  "CACHE_DRIVER": "redis",
  "SESSION_DRIVER": "redis",
  "REDIS_HOST": "your-redis-cache.redis.cache.windows.net",
  "REDIS_PASSWORD": "your_redis_key",
  "REDIS_PORT": "6380"
}
```

## 🗄️ Step 2: Set Up Azure Databases

### 2.1 Create Azure Database for MySQL

```bash
# Login to Azure
az login

# Create resource group
az group create \
    --name luxe-hair-studio-rg \
    --location "East US"

# Create MySQL server
az mysql flexible-server create \
    --resource-group luxe-hair-studio-rg \
    --name luxe-hair-mysql \
    --admin-user luxeadmin \
    --admin-password 'YourSecurePassword123!' \
    --location "East US" \
    --tier Burstable \
    --sku-name Standard_B1ms \
    --storage-size 20 \
    --version 8.0.21

# Create database
az mysql flexible-server db create \
    --resource-group luxe-hair-studio-rg \
    --server-name luxe-hair-mysql \
    --database-name luxe_hair_studio

# Configure firewall (allow Azure services)
az mysql flexible-server firewall-rule create \
    --resource-group luxe-hair-studio-rg \
    --server-name luxe-hair-mysql \
    --rule-name AllowAzureServices \
    --start-ip-address 0.0.0.0 \
    --end-ip-address 0.0.0.0
```

### 2.2 Create Azure Cosmos DB (MongoDB API)

```bash
# Create Cosmos DB account with MongoDB API
az cosmosdb create \
    --resource-group luxe-hair-studio-rg \
    --name luxe-hair-cosmosdb \
    --kind MongoDB \
    --locations regionName="East US" failoverPriority=0 isZoneRedundant=False \
    --default-consistency-level Session \
    --enable-multiple-write-locations false

# Create MongoDB database
az cosmosdb mongodb database create \
    --account-name luxe-hair-cosmosdb \
    --resource-group luxe-hair-studio-rg \
    --name luxe_hair_studio

# Create collections for services and deals
az cosmosdb mongodb collection create \
    --account-name luxe-hair-cosmosdb \
    --resource-group luxe-hair-studio-rg \
    --database-name luxe_hair_studio \
    --name services \
    --throughput 400

az cosmosdb mongodb collection create \
    --account-name luxe-hair-cosmosdb \
    --resource-group luxe-hair-studio-rg \
    --database-name luxe_hair_studio \
    --name deals \
    --throughput 400

# Get connection string
az cosmosdb keys list \
    --resource-group luxe-hair-studio-rg \
    --name luxe-hair-cosmosdb \
    --type connection-strings
```

### 2.3 Create Azure Redis Cache

```bash
# Create Redis cache
az redis create \
    --resource-group luxe-hair-studio-rg \
    --name luxe-hair-redis \
    --location "East US" \
    --sku Basic \
    --vm-size c0

# Get Redis keys
az redis list-keys \
    --resource-group luxe-hair-studio-rg \
    --name luxe-hair-redis
```

## 🌐 Step 3: Create Azure App Service

### 3.1 Create App Service Plan

```bash
# Create App Service Plan (Linux)
az appservice plan create \
    --resource-group luxe-hair-studio-rg \
    --name luxe-hair-plan \
    --location "East US" \
    --is-linux \
    --sku B1

# Create Web App
az webapp create \
    --resource-group luxe-hair-studio-rg \
    --plan luxe-hair-plan \
    --name your-unique-app-name \
    --runtime "PHP|8.2" \
    --deployment-local-git
```

### 3.2 Configure PHP Settings

```bash
# Set PHP version and extensions
az webapp config set \
    --resource-group luxe-hair-studio-rg \
    --name your-unique-app-name \
    --php-version 8.2

# Enable required PHP extensions
az webapp config set \
    --resource-group luxe-hair-studio-rg \
    --name your-unique-app-name \
    --startup-file "composer install --optimize-autoloader --no-dev && php artisan config:cache && php artisan route:cache && php artisan view:cache"
```

### 3.3 Configure Application Settings

```bash
# Set environment variables
az webapp config appsettings set \
    --resource-group luxe-hair-studio-rg \
    --name your-unique-app-name \
    --settings @azure/app-settings.json

# Configure document root
az webapp config set \
    --resource-group luxe-hair-studio-rg \
    --name your-unique-app-name \
    --startup-file "cp /home/site/wwwroot/.env.azure /home/site/wwwroot/.env && composer install --optimize-autoloader --no-dev && php artisan config:cache && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"
```

## 📂 Step 4: Configure Storage (Optional)

### 4.1 Create Azure Storage Account

```bash
# Create storage account
az storage account create \
    --resource-group luxe-hair-studio-rg \
    --name luxehairstorage \
    --location "East US" \
    --sku Standard_LRS

# Get storage keys
az storage account keys list \
    --resource-group luxe-hair-studio-rg \
    --account-name luxehairstorage

# Create blob container
az storage container create \
    --account-name luxehairstorage \
    --name salon-uploads \
    --public-access blob
```

### 4.2 Configure Laravel for Azure Blob Storage

Add to `config/filesystems.php`:

```php
'azure' => [
    'driver' => 'azure',
    'account' => env('AZURE_STORAGE_ACCOUNT_NAME'),
    'key' => env('AZURE_STORAGE_ACCOUNT_KEY'),
    'container' => env('AZURE_STORAGE_CONTAINER'),
    'url' => env('AZURE_STORAGE_URL'),
],
```

Install Azure Storage package:

```bash
composer require league/flysystem-azure-blob-storage
```

## 🚀 Step 5: Deploy Your Application

### 5.1 Initialize Git Deployment

```bash
# Get Git URL
DEPLOY_URL=$(az webapp deployment source config-local-git \
    --resource-group luxe-hair-studio-rg \
    --name your-unique-app-name \
    --query url \
    --output tsv)

# Add Azure remote
git remote add azure $DEPLOY_URL

# Deploy to Azure
git add .
git commit -m "Initial Azure deployment"
git push azure main
```

### 5.2 Alternative: GitHub Actions Deployment

Create `.github/workflows/azure-deploy.yml`:

```yaml
name: Deploy to Azure

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest

    steps:
    - uses: actions/checkout@v4

    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: mbstring, xml, ctype, iconv, intl, pdo, pdo_mysql, redis, mongodb

    - name: Setup Node.js
      uses: actions/setup-node@v4
      with:
        node-version: '18'
        cache: 'npm'

    - name: Install Composer dependencies
      run: composer install --optimize-autoloader --no-dev --no-interaction

    - name: Install NPM dependencies
      run: npm ci

    - name: Build assets
      run: npm run build

    - name: Deploy to Azure
      uses: azure/webapps-deploy@v2
      with:
        app-name: 'your-unique-app-name'
        publish-profile: ${{ secrets.AZURE_WEBAPP_PUBLISH_PROFILE }}
        package: .
```

## 🔧 Step 6: Post-Deployment Configuration

### 6.1 Run Migrations and Seeders

```bash
# SSH into your Azure App Service (if needed)
az webapp ssh \
    --resource-group luxe-hair-studio-rg \
    --name your-unique-app-name

# In the app service terminal:
cd /home/site/wwwroot

# Run migrations
php artisan migrate --force

# Seed MongoDB data
php artisan db:seed --class=MongoDBSeeder --force

# Clear caches
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6.2 Configure Custom Domain (Optional)

```bash
# Add custom domain
az webapp config hostname add \
    --resource-group luxe-hair-studio-rg \
    --webapp-name your-unique-app-name \
    --hostname yourdomain.com

# Enable SSL
az webapp config ssl bind \
    --resource-group luxe-hair-studio-rg \
    --name your-unique-app-name \
    --certificate-thumbprint YOUR_CERT_THUMBPRINT \
    --ssl-type SNI
```

## 🔒 Step 7: Security Configuration

### 7.1 Configure App Service Security

```bash
# Enable HTTPS only
az webapp update \
    --resource-group luxe-hair-studio-rg \
    --name your-unique-app-name \
    --https-only true

# Configure minimum TLS version
az webapp config set \
    --resource-group luxe-hair-studio-rg \
    --name your-unique-app-name \
    --min-tls-version 1.2
```

### 7.2 Database Security

```bash
# Configure MySQL firewall rules
az mysql flexible-server firewall-rule create \
    --resource-group luxe-hair-studio-rg \
    --server-name luxe-hair-mysql \
    --rule-name "AllowAppService" \
    --start-ip-address YOUR_APP_SERVICE_IP \
    --end-ip-address YOUR_APP_SERVICE_IP

# Configure Cosmos DB firewall
az cosmosdb network-rule add \
    --resource-group luxe-hair-studio-rg \
    --name luxe-hair-cosmosdb \
    --subnet YOUR_SUBNET_ID
```

## 📊 Step 8: Monitoring and Logging

### 8.1 Enable Application Insights

```bash
# Create Application Insights
az monitor app-insights component create \
    --resource-group luxe-hair-studio-rg \
    --app luxe-hair-insights \
    --location "East US" \
    --kind web

# Get instrumentation key
az monitor app-insights component show \
    --resource-group luxe-hair-studio-rg \
    --app luxe-hair-insights \
    --query instrumentationKey
```

### 8.2 Configure Logging

Add to your `.env.azure`:

```env
# Application Insights
APPINSIGHTS_INSTRUMENTATIONKEY=your_instrumentation_key

# Laravel Logging
LOG_CHANNEL=single
LOG_LEVEL=info
```

## 🧪 Step 9: Testing Your Deployment

### 9.1 Verify Application Components

Test these URLs after deployment:

```
https://your-app-name.azurewebsites.net          # Home page
https://your-app-name.azurewebsites.net/login    # Authentication
https://your-app-name.azurewebsites.net/book-service  # Booking system
https://your-app-name.azurewebsites.net/admin/services  # Admin panel
https://your-app-name.azurewebsites.net/api/services    # API endpoint
```

### 9.2 Test Database Connections

```bash
# Test MySQL connection
az webapp log tail \
    --resource-group luxe-hair-studio-rg \
    --name your-unique-app-name

# Test MongoDB connection via Azure portal or CLI
az cosmosdb mongodb database show \
    --account-name luxe-hair-cosmosdb \
    --resource-group luxe-hair-studio-rg \
    --name luxe_hair_studio
```

## 🔧 Step 10: Troubleshooting Common Issues

### 10.1 Application Not Starting

**Problem**: 500 errors or app not loading

**Solutions**:
```bash
# Check logs
az webapp log tail --name your-app-name --resource-group luxe-hair-studio-rg

# Verify environment variables
az webapp config appsettings list --name your-app-name --resource-group luxe-hair-studio-rg

# Check PHP configuration
az webapp config show --name your-app-name --resource-group luxe-hair-studio-rg
```

### 10.2 Database Connection Issues

**Problem**: Database connection errors

**Solutions**:
```bash
# Check MySQL firewall rules
az mysql flexible-server firewall-rule list \
    --resource-group luxe-hair-studio-rg \
    --server-name luxe-hair-mysql

# Test Cosmos DB connection
az cosmosdb keys list \
    --resource-group luxe-hair-studio-rg \
    --name luxe-hair-cosmosdb
```

### 10.3 MongoDB Extension Missing

**Problem**: MongoDB functionality not working

**Solutions**:
1. Ensure PHP MongoDB extension is available in Azure App Service
2. Use Azure Cosmos DB MongoDB API instead of native MongoDB
3. Update connection strings for Cosmos DB SSL requirements

### 10.4 Asset Build Issues

**Problem**: CSS/JS not loading

**Solutions**:
```bash
# Rebuild assets locally and redeploy
npm run build
git add public/build
git commit -m "Update built assets"
git push azure main
```

## 💰 Step 11: Cost Optimization

### 11.1 Choose Appropriate Tiers

**Development/Testing:**
- App Service: B1 ($13.14/month)
- MySQL: Burstable B1ms ($9.73/month)
- Cosmos DB: 400 RU/s ($23.36/month)
- Redis: Basic C0 ($15.48/month)

**Production:**
- App Service: S1 ($73.00/month)
- MySQL: General Purpose GP_Gen5_2 ($102.20/month)
- Cosmos DB: 1000 RU/s ($58.40/month)
- Redis: Standard C1 ($55.80/month)

### 11.2 Monitoring Costs

```bash
# View current costs
az consumption usage list \
    --resource-group luxe-hair-studio-rg

# Set up budget alerts
az consumption budget create \
    --resource-group luxe-hair-studio-rg \
    --budget-name LuxeHairBudget \
    --amount 200 \
    --time-grain Monthly
```

## 🔄 Step 12: Backup and Disaster Recovery

### 12.1 Database Backups

**MySQL:**
```bash
# Enable automated backups (retention period)
az mysql flexible-server parameter set \
    --resource-group luxe-hair-studio-rg \
    --server-name luxe-hair-mysql \
    --name backup_retention_days \
    --value 7
```

**Cosmos DB:**
```bash
# Backups are automatic, but you can enable Point-in-Time Restore
az cosmosdb restore \
    --resource-group luxe-hair-studio-rg \
    --target-database-account-name luxe-hair-cosmosdb-restored \
    --account-name luxe-hair-cosmosdb \
    --restore-timestamp 2024-01-01T00:00:00Z
```

### 12.2 Application Backup

```bash
# Create deployment slots for zero-downtime deployments
az webapp deployment slot create \
    --resource-group luxe-hair-studio-rg \
    --name your-unique-app-name \
    --slot staging
```

## 📝 Step 13: Maintenance and Updates

### 13.1 Regular Updates

Create a maintenance checklist:

1. **Monthly**:
   - Update Laravel and dependencies
   - Review security patches
   - Check application performance

2. **Weekly**:
   - Monitor application logs
   - Check database performance
   - Review cost usage

3. **Daily**:
   - Monitor application availability
   - Check for error notifications

### 13.2 Update Process

```bash
# Update dependencies
composer update

# Update Node packages
npm update

# Test locally
php artisan test

# Deploy updates
git add .
git commit -m "Update dependencies"
git push azure main
```

## ✅ Deployment Checklist

Before going live, ensure:

- [ ] All environment variables are configured
- [ ] Database migrations have run successfully
- [ ] MongoDB seeder has populated catalog data
- [ ] SSL certificate is configured
- [ ] Custom domain is set up (if applicable)
- [ ] Application Insights is monitoring
- [ ] Backup strategy is in place
- [ ] Cost monitoring is configured
- [ ] Security settings are applied
- [ ] All application features are tested

## 🎉 Conclusion

Your Luxe Hair Studio application is now successfully deployed to Azure! The hybrid architecture with MySQL and MongoDB provides excellent performance and scalability for your salon management needs.

**Key URLs after deployment:**
- **Application**: https://your-app-name.azurewebsites.net
- **Admin Panel**: https://your-app-name.azurewebsites.net/admin
- **API**: https://your-app-name.azurewebsites.net/api

**Support Resources:**
- [Azure App Service Documentation](https://docs.microsoft.com/en-us/azure/app-service/)
- [Laravel Documentation](https://laravel.com/docs)
- [Azure Cosmos DB MongoDB API](https://docs.microsoft.com/en-us/azure/cosmos-db/mongodb/)

---

*This tutorial covers a complete production deployment. For development environments, you can use smaller instance sizes and simplified configurations to reduce costs.*