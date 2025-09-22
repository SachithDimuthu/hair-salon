# Luxe Hair Studio - Production Deployment Guide

This comprehensive guide covers deploying the Luxe Hair Studio salon management system to production environments.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Production Environment Setup](#production-environment-setup)
- [Security Configuration](#security-configuration)
- [Database Setup](#database-setup)
- [Hosting Providers](#hosting-providers)
  - [Render Deployment](#render-deployment)
  - [DigitalOcean Deployment](#digitalocean-deployment)
  - [Apache/XAMPP Deployment](#apachexampp-deployment)
- [SSL/TLS Configuration](#ssltls-configuration)
- [Performance Optimization](#performance-optimization)
- [Monitoring & Maintenance](#monitoring--maintenance)
- [Troubleshooting](#troubleshooting)

## Prerequisites

Before deploying to production, ensure you have:

- **PHP 8.2+** with required extensions:
  - BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML
- **Composer** for dependency management
- **Node.js 18+** and **npm/yarn** for frontend assets
- **Database**: MySQL 8.0+ or PostgreSQL 13+
- **Redis** for caching and sessions (recommended)
- **Git** for version control
- **SSL Certificate** for HTTPS

## Production Environment Setup

### 1. Clone Repository

```bash
git clone https://github.com/yourusername/luxe-hair-studio.git
cd luxe-hair-studio
```

### 2. Install Dependencies

```bash
# PHP dependencies
composer install --optimize-autoloader --no-dev

# Frontend dependencies
npm install
npm run build
```

### 3. Environment Configuration

Copy the production environment file:

```bash
cp .env.production .env
```

**Critical Environment Variables:**

```env
# Application
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
APP_KEY=base64:GENERATE_NEW_KEY

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=luxe_hair_studio
DB_USERNAME=your_username
DB_PASSWORD=your_secure_password

# Cache & Sessions
CACHE_DRIVER=redis
SESSION_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=your_redis_password
REDIS_PORT=6379

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls

# Security
SESSION_SECURE_COOKIE=true
SANCTUM_STATEFUL_DOMAINS=yourdomain.com
```

### 4. Application Setup

```bash
# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate --force

# Seed default data (optional)
php artisan db:seed

# Optimize application
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Link storage
php artisan storage:link
```

## Security Configuration

### 1. File Permissions

Set proper file permissions for security:

```bash
# Set directory permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Storage and bootstrap cache
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 2. Security Headers

The application includes `SecurityHeadersMiddleware` with:

- **Content Security Policy (CSP)**
- **HTTP Strict Transport Security (HSTS)**
- **X-Frame-Options**
- **X-Content-Type-Options**
- **Referrer Policy**

### 3. Rate Limiting

API endpoints are protected with:
- 60 requests per minute for general API
- 5 attempts per minute for authentication

## Database Setup

### MySQL Configuration

1. **Create Database:**
```sql
CREATE DATABASE luxe_hair_studio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'luxe_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON luxe_hair_studio.* TO 'luxe_user'@'localhost';
FLUSH PRIVILEGES;
```

2. **Optimize MySQL for Production:**
```sql
-- my.cnf optimizations
[mysqld]
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
max_connections = 200
query_cache_type = 1
query_cache_size = 64M
```

### PostgreSQL Configuration

1. **Create Database:**
```sql
CREATE DATABASE luxe_hair_studio;
CREATE USER luxe_user WITH PASSWORD 'secure_password';
GRANT ALL PRIVILEGES ON DATABASE luxe_hair_studio TO luxe_user;
```

2. **Update Environment:**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
```

## Hosting Providers

### Render Deployment

**Render** provides excellent Laravel hosting with automatic deployments.

#### 1. Prepare Repository

Ensure your repository includes:
- `render.yaml` (build configuration)
- `scripts/production-optimize.sh`

#### 2. Create Web Service

1. Connect your GitHub repository
2. Configure build settings:
   - **Build Command:** `scripts/production-optimize.sh`
   - **Start Command:** `php artisan serve --host=0.0.0.0 --port=$PORT`

#### 3. Environment Variables

Set in Render dashboard:
```
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:GENERATE_NEW_KEY
APP_URL=https://your-app.onrender.com
DATABASE_URL=postgresql://user:password@host:port/database
REDIS_URL=redis://user:password@host:port
```

#### 4. Database Service

Create PostgreSQL database:
1. Add PostgreSQL service
2. Copy connection details to web service environment

#### 5. Custom Domain (Optional)

1. Add custom domain in Render
2. Update `APP_URL` environment variable
3. Configure DNS CNAME record

### DigitalOcean Deployment

**DigitalOcean App Platform** provides scalable hosting.

#### 1. App Specification

Create `.do/app.yaml`:

```yaml
name: luxe-hair-studio
services:
- name: web
  source_dir: /
  github:
    repo: yourusername/luxe-hair-studio
    branch: main
  run_command: php artisan serve --host=0.0.0.0 --port=$PORT
  environment_slug: php
  instance_count: 1
  instance_size_slug: basic-xxs
  envs:
  - key: APP_ENV
    value: production
  - key: APP_DEBUG
    value: "false"
  - key: APP_KEY
    type: SECRET
    value: YOUR_APP_KEY

databases:
- name: db
  engine: PG
  num_nodes: 1
  size: db-s-dev-database
```

#### 2. Deploy Application

```bash
# Install doctl CLI
snap install doctl

# Authenticate
doctl auth init

# Deploy app
doctl apps create --spec .do/app.yaml
```

#### 3. Configure Database

```bash
# Get database connection info
doctl databases connection db-name

# Update environment variables
doctl apps update YOUR_APP_ID --spec .do/app.yaml
```

### Apache/XAMPP Deployment

For **shared hosting** or **XAMPP** environments.

#### 1. Upload Files

Upload all files except:
- `.git/`
- `node_modules/`
- `tests/`
- `.github/`

#### 2. Apache Configuration

Create `.htaccess` in public directory:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
</IfModule>

# Prevent access to sensitive files
<Files .env>
    Order allow,deny
    Deny from all
</Files>

<Files composer.json>
    Order allow,deny
    Deny from all
</Files>
```

#### 3. Document Root

Set document root to `/public` directory or create symbolic link:

```bash
# If you can't change document root
ln -s public html
```

#### 4. PHP Configuration

Ensure `php.ini` settings:

```ini
memory_limit = 256M
max_execution_time = 300
upload_max_filesize = 20M
post_max_size = 20M
max_input_vars = 3000

# Security
expose_php = Off
display_errors = Off
log_errors = On
```

## SSL/TLS Configuration

### 1. Let's Encrypt (Free SSL)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-apache

# Generate certificate
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com

# Auto-renewal
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

### 2. Cloudflare SSL

1. Add domain to Cloudflare
2. Update nameservers
3. Enable SSL/TLS encryption mode: "Full (strict)"
4. Force HTTPS redirects

### 3. Manual SSL Certificate

```apache
# Apache VirtualHost with SSL
<VirtualHost *:443>
    ServerName yourdomain.com
    DocumentRoot /var/www/luxe-hair-studio/public
    
    SSLEngine on
    SSLCertificateFile /path/to/certificate.crt
    SSLCertificateKeyFile /path/to/private.key
    SSLCertificateChainFile /path/to/chain.crt
    
    # Security headers
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
</VirtualHost>
```

## Performance Optimization

### 1. Server-Level Optimizations

**Apache Optimizations:**

```apache
# Enable compression
LoadModule deflate_module modules/mod_deflate.so

<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/plain
    AddOutputFilterByType DEFLATE text/html
    AddOutputFilterByType DEFLATE text/xml
    AddOutputFilterByType DEFLATE text/css
    AddOutputFilterByType DEFLATE application/xml
    AddOutputFilterByType DEFLATE application/xhtml+xml
    AddOutputFilterByType DEFLATE application/rss+xml
    AddOutputFilterByType DEFLATE application/javascript
    AddOutputFilterByType DEFLATE application/x-javascript
</IfModule>

# Enable caching
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/pdf "access plus 1 month"
    ExpiresByType text/javascript "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

### 2. Laravel Optimizations

**Run optimization commands:**

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Cache events
php artisan event:cache

# Optimize autoloader
composer dump-autoload --optimize
```

### 3. Database Optimization

**Add database indexes:**

```php
// Create migration for indexes
php artisan make:migration add_performance_indexes

// In migration file:
public function up()
{
    Schema::table('appointments', function (Blueprint $table) {
        $table->index(['user_id', 'status']);
        $table->index(['service_id', 'appointment_date']);
        $table->index('appointment_date');
    });
    
    Schema::table('users', function (Blueprint $table) {
        $table->index('email');
        $table->index('role');
    });
}
```

### 4. Frontend Optimization

**Vite production build** (already configured):

```bash
# Build optimized assets
npm run build

# Assets are automatically:
# - Minified
# - Compressed
# - Versioned for cache busting
# - Split into chunks
```

## Monitoring & Maintenance

### 1. Log Monitoring

**Monitor Laravel logs:**

```bash
# View latest logs
tail -f storage/logs/laravel.log

# Monitor for errors
grep "ERROR" storage/logs/laravel.log

# Monitor performance
grep "SLOW QUERY" storage/logs/laravel.log
```

### 2. Health Checks

**Create health check endpoint:**

```php
// routes/web.php
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now(),
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
        'cache' => Cache::store()->getStore() ? 'connected' : 'disconnected',
    ]);
});
```

### 3. Backup Strategy

**Database backups:**

```bash
# MySQL backup
mysqldump -u username -p luxe_hair_studio > backup_$(date +%Y%m%d_%H%M%S).sql

# PostgreSQL backup
pg_dump luxe_hair_studio > backup_$(date +%Y%m%d_%H%M%S).sql

# Automated backup script
#!/bin/bash
BACKUP_DIR="/backups"
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/luxe_backup_$DATE.sql
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
```

### 4. Performance Monitoring

**Monitor key metrics:**

```bash
# Server resources
top
htop
iostat -x 1

# Database performance
SHOW PROCESSLIST;
SHOW ENGINE INNODB STATUS;

# Laravel performance
php artisan horizon:status  # If using queues
php artisan schedule:list   # Scheduled tasks
```

## Troubleshooting

### Common Issues

#### 1. 500 Internal Server Error

**Diagnosis:**
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Check Apache error logs
tail -f /var/log/apache2/error.log

# Check permissions
ls -la storage/ bootstrap/cache/
```

**Solutions:**
- Verify file permissions (755 for directories, 644 for files)
- Check `.env` configuration
- Ensure all caches are cleared
- Verify database connection

#### 2. Database Connection Issues

**Check connection:**
```bash
# Test database connection
php artisan tinker
DB::connection()->getPdo();
```

**Common fixes:**
- Verify database credentials in `.env`
- Check database server status
- Ensure database exists
- Check firewall settings

#### 3. Asset Loading Issues

**Diagnosis:**
```bash
# Check if assets exist
ls -la public/build/

# Rebuild assets
npm run build

# Check Vite manifest
cat public/build/manifest.json
```

**Solutions:**
- Run `npm run build` to rebuild assets
- Check `APP_URL` matches your domain
- Verify `public/build` directory permissions
- Clear browser cache

#### 4. SSL Certificate Issues

**Check certificate:**
```bash
# Test SSL
openssl s_client -connect yourdomain.com:443

# Check certificate expiry
openssl x509 -in certificate.crt -text -noout
```

**Solutions:**
- Renew expired certificates
- Verify certificate chain
- Check Apache SSL configuration
- Ensure HTTPS redirects are working

#### 5. Performance Issues

**Diagnosis:**
```bash
# Check server load
uptime
free -m
df -h

# Profile Laravel
composer require barryvdh/laravel-debugbar --dev
```

**Solutions:**
- Enable opcache
- Optimize database queries
- Use Redis for caching
- Enable gzip compression
- Optimize images

### Emergency Procedures

#### 1. Quick Rollback

```bash
# Rollback to previous commit
git reset --hard HEAD~1

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 2. Maintenance Mode

```bash
# Enable maintenance mode
php artisan down --message="Scheduled maintenance" --retry=60

# Disable maintenance mode
php artisan up
```

#### 3. Database Recovery

```bash
# Restore from backup
mysql -u username -p luxe_hair_studio < backup_file.sql

# Re-run migrations if needed
php artisan migrate --force
```

## Security Checklist

Before going live, ensure:

- [ ] `APP_DEBUG=false` in production
- [ ] Strong `APP_KEY` generated
- [ ] Database credentials are secure
- [ ] SSL certificate is installed and valid
- [ ] Security headers are configured
- [ ] File permissions are correct
- [ ] Sensitive files are protected
- [ ] Rate limiting is enabled
- [ ] CSRF protection is active
- [ ] Input validation is implemented
- [ ] Error pages don't expose sensitive information
- [ ] Backup strategy is in place
- [ ] Monitoring is configured

## Post-Deployment Testing

Verify everything works:

1. **Functionality Testing:**
   - User registration/login
   - Appointment booking
   - Service management
   - Payment processing
   - Email notifications

2. **Performance Testing:**
   - Page load times
   - Database query performance
   - API response times

3. **Security Testing:**
   - SSL certificate validation
   - Security headers check
   - XSS/CSRF protection
   - Input validation

4. **Cross-Browser Testing:**
   - Chrome, Firefox, Safari, Edge
   - Mobile responsiveness
   - JavaScript functionality

## Support & Updates

### Regular Maintenance

- **Weekly:** Check error logs, backup database
- **Monthly:** Update dependencies, security patches
- **Quarterly:** Performance review, optimization
- **Annually:** SSL certificate renewal, security audit

### Getting Help

- Laravel Documentation: https://laravel.com/docs
- Laravel Community: https://laracasts.com
- Stack Overflow: Laravel tag
- GitHub Issues: Report bugs

---

**Congratulations!** Your Luxe Hair Studio application is now deployed and ready for production use.

For quick deployment, see `DEPLOYMENT_NEXT_STEPS.md` for simplified instructions.