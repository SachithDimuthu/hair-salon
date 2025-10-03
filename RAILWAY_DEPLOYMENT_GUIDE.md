# Railway Deployment Guide for Luxe Hair Studio

## 🚀 Complete Guide to Deploy Laravel Hair Salon with Dual Database Setup

This comprehensive guide will walk you through deploying your Laravel-based hair salon booking system to Railway.app with a hybrid database architecture using PostgreSQL and MongoDB.

## 📋 Table of Contents

1. [Prerequisites](#prerequisites)
2. [Railway Account Setup](#railway-account-setup)
3. [Project Preparation](#project-preparation)
4. [Database Setup](#database-setup)
5. [Environment Configuration](#environment-configuration)
6. [Deployment Configuration](#deployment-configuration)
7. [Deploy to Railway](#deploy-to-railway)
8. [Post-Deployment Setup](#post-deployment-setup)
9. [Troubleshooting](#troubleshooting)
10. [Domain & SSL](#domain--ssl)

## 🔧 Prerequisites

Before starting, ensure you have:

- ✅ **Railway Account**: [Sign up at railway.app](https://railway.app)
- ✅ **GitHub Account**: Your code repository
- ✅ **Laravel Project**: Working local build
- ✅ **Composer & NPM**: For dependency management
- ✅ **Railway CLI** (optional): `npm install -g @railway/cli`

## 🏗️ Railway Account Setup

### 1. Create Railway Account
1. Visit [railway.app](https://railway.app)
2. Sign up with GitHub (recommended for easy repo connection)
3. Verify your account

### 2. Install Railway CLI (Optional but Recommended)
```bash
npm install -g @railway/cli
railway login
```

## 📁 Project Preparation

### 1. Update Composer.json for Railway
Your `composer.json` should include the platform requirements:

```json
{
    "require": {
        "php": "^8.2",
        "ext-mongodb": "*",
        "ext-pdo": "*",
        "ext-openssl": "*",
        "ext-tokenizer": "*"
    },
    "scripts": {
        "post-install-cmd": [
            "php artisan clear-compiled",
            "php artisan optimize"
        ]
    }
}
```

### 2. Verify Package.json Build Scripts
Ensure your `package.json` has proper build scripts:

```json
{
    "scripts": {
        "build": "vite build",
        "dev": "vite",
        "prod": "npm run build"
    }
}
```

## 🗄️ Database Setup

### 1. PostgreSQL Database (Main Database)
1. In Railway dashboard, click **"New Project"**
2. Select **"Provision PostgreSQL"**
3. Note down the connection details:
   - `PGHOST`
   - `PGPORT` 
   - `PGDATABASE`
   - `PGUSER`
   - `PGPASSWORD`

### 2. MongoDB Database (Catalog/Services)
1. Create another service in the same project
2. Search for **"MongoDB"** in templates
3. Deploy MongoDB template
4. Note down MongoDB connection details:
   - `MONGO_URL`
   - `MONGODB_URI`

### 3. Redis Cache (Optional but Recommended)
1. Add Redis service to your project
2. Select **"Redis"** template
3. Note Redis connection URL

## ⚙️ Environment Configuration

Create a `.env.railway` file for Railway-specific settings:

```env
# Application
APP_NAME="Luxe Hair Studio"
APP_ENV=production
APP_KEY=base64:YOUR_APP_KEY_HERE
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://your-app-name.railway.app

# Database - PostgreSQL (Primary)
DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}

# MongoDB (Services/Catalog)
DB_MONGO_HOST=${MONGODB_HOST}
DB_MONGO_PORT=${MONGODB_PORT}
DB_MONGO_DATABASE=luxe_hair_catalog
DB_MONGO_USERNAME=${MONGODB_USERNAME}
DB_MONGO_PASSWORD=${MONGODB_PASSWORD}
MONGODB_URI=${MONGO_URL}

# Cache & Sessions (Redis)
CACHE_DRIVER=redis
SESSION_DRIVER=redis
REDIS_HOST=${REDIS_HOST}
REDIS_PASSWORD=${REDIS_PASSWORD}
REDIS_PORT=${REDIS_PORT}

# Queue
QUEUE_CONNECTION=redis

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@luxehair.com
MAIL_FROM_NAME="Luxe Hair Studio"

# File Storage (Railway Static Files)
FILESYSTEM_DISK=public

# Security
SANCTUM_STATEFUL_DOMAINS=${APP_URL}
SESSION_DOMAIN=.railway.app

# Optimization
OPTIMIZE_CLEAR_CACHE=true
```

## 🚀 Deployment Configuration

### 1. Create Railway Configuration File

Create `railway.json`:

```json
{
  "$schema": "https://railway.app/railway.schema.json",
  "build": {
    "builder": "NIXPACKS",
    "buildCommand": "npm ci && npm run build && composer install --optimize-autoloader --no-dev"
  },
  "deploy": {
    "startCommand": "php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php-fpm",
    "restartPolicyType": "ON_FAILURE",
    "restartPolicyMaxRetries": 10
  }
}
```

### 2. Create Procfile

Create `Procfile`:

```
web: php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && vendor/bin/heroku-php-apache2 public/
```

### 3. Create Nginx Configuration

Create `nginx.conf`:

```nginx
server {
    listen 80;
    server_name _;
    root /app/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }

    client_max_body_size 100M;
}
```

### 4. Create Build Script

Create `scripts/railway-build.sh`:

```bash
#!/bin/bash

echo "🚀 Starting Railway build process..."

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --optimize-autoloader --no-dev --verbose

# Install Node dependencies
echo "📦 Installing Node dependencies..."
npm ci

# Build frontend assets
echo "🏗️  Building frontend assets..."
npm run build

# Clear Laravel caches
echo "🧹 Clearing application caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "✅ Build process completed successfully!"
```

Make it executable:
```bash
chmod +x scripts/railway-build.sh
```

## 🚀 Deploy to Railway

### Method 1: GitHub Integration (Recommended)

1. **Connect Repository**:
   - In Railway dashboard, click **"New Project"**
   - Select **"Deploy from GitHub repo"**
   - Choose your hair salon repository

2. **Add Environment Variables**:
   - Go to your project settings
   - Add all variables from your `.env.railway` file
   - Set `APP_KEY`: Run `php artisan key:generate --show` locally

3. **Configure Build**:
   - Railway will auto-detect Laravel
   - Ensure build command includes frontend build: `npm run build`

4. **Deploy**:
   - Railway will automatically build and deploy
   - Monitor deployment in the Railway dashboard

### Method 2: Railway CLI

```bash
# Login to Railway
railway login

# Link to your project
railway link

# Set environment variables
railway variables set APP_ENV=production
railway variables set APP_DEBUG=false
# ... add all other variables

# Deploy
railway up
```

## 🔧 Post-Deployment Setup

### 1. Run Database Migrations

```bash
# Via Railway CLI
railway run php artisan migrate --force

# Or add to your start command in railway.json
```

### 2. Seed Initial Data (Optional)

```bash
railway run php artisan db:seed --class=BasicDataSeeder
```

### 3. Create Storage Link

```bash
railway run php artisan storage:link
```

### 4. Optimize Application

```bash
railway run php artisan optimize
railway run php artisan config:cache
railway run php artisan route:cache
railway run php artisan view:cache
```

## 🔍 Troubleshooting

### Common Issues & Solutions

#### 1. **Build Failures**
```bash
# Check build logs
railway logs --tail

# Clear build cache
railway service delete
# Redeploy
```

#### 2. **Database Connection Issues**
- Verify PostgreSQL service is running
- Check environment variables match database credentials
- Ensure `pgsql` driver is specified in database config

#### 3. **MongoDB Connection Problems**
```php
// Test MongoDB connection
railway run php artisan tinker
>>> DB::connection('mongodb')->getPdo()
```

#### 4. **Asset Loading Issues**
```bash
# Rebuild assets
railway run npm run build
railway run php artisan view:clear
```

#### 5. **Permission Issues**
```bash
# Set proper permissions
railway run chmod -R 755 storage bootstrap/cache
```

### 6. **Environment Variable Issues**
```bash
# List all environment variables
railway variables

# Test configuration
railway run php artisan config:show
```

## 🌐 Domain & SSL

### 1. Custom Domain Setup
1. In Railway dashboard, go to **Settings > Domains**
2. Click **"Add Domain"**
3. Enter your custom domain
4. Update DNS records:
   ```
   Type: CNAME
   Name: www (or @)
   Value: your-app.railway.app
   ```

### 2. SSL Certificate
- Railway automatically provides SSL certificates
- No additional configuration needed
- Certificates auto-renew

## 📈 Performance Optimization

### 1. Enable Laravel Optimizations

Add to your deployment script:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 2. Database Optimization
```sql
-- PostgreSQL optimizations
CREATE INDEX idx_bookings_date ON bookings(booking_date);
CREATE INDEX idx_users_email ON users(email);
```

### 3. Redis Caching
```php
// config/cache.php - ensure Redis is default
'default' => env('CACHE_DRIVER', 'redis'),
```

## 🔒 Security Checklist

- ✅ **Environment Variables**: All sensitive data in Railway variables
- ✅ **Debug Mode**: `APP_DEBUG=false` in production
- ✅ **HTTPS**: Enforce HTTPS redirects
- ✅ **Database**: Use strong passwords
- ✅ **File Permissions**: Proper storage permissions
- ✅ **CORS**: Configure allowed origins

## 💰 Railway Pricing

- **Hobby Plan**: $5/month - Perfect for small projects
- **Pro Plan**: $20/month - Production applications
- **Database**: ~$5-10/month per database
- **Total Estimated Cost**: $15-40/month depending on usage

## 🎉 Deployment Complete!

Your Laravel hair salon application should now be live on Railway with:
- ✅ **PostgreSQL** for user data, bookings, payments
- ✅ **MongoDB** for services catalog and flexible data
- ✅ **Redis** for caching and sessions
- ✅ **Automatic SSL** and custom domain support
- ✅ **Continuous deployment** from GitHub

## 📞 Support Resources

- **Railway Documentation**: [docs.railway.app](https://docs.railway.app)
- **Railway Discord**: [Community Support](https://discord.gg/railway)
- **Laravel Documentation**: [laravel.com/docs](https://laravel.com/docs)
- **MongoDB Laravel**: [jenssegers/laravel-mongodb](https://github.com/jenssegers/laravel-mongodb)

---

**Need help?** Feel free to reach out or check the troubleshooting section above!