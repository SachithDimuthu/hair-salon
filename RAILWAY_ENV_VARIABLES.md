# Railway Environment Variables Configuration
# Copy these exact values into Railway's environment variables section

# ===========================================
# APPLICATION SETTINGS
# ===========================================
APP_NAME="Luxe Hair Studio"
APP_ENV=production
APP_KEY=base64:GluQIaHpPcpk8ikyE6nTihsvO1ySpv5AY1x55dETb38=
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://hair-salon-production.up.railway.app

# ===========================================
# DATABASE SETTINGS (PostgreSQL - Primary)
# ===========================================
# Railway will automatically provide these when you add PostgreSQL service:
DB_CONNECTION=pgsql
# DB_HOST=${PGHOST}
# DB_PORT=${PGPORT}
# DB_DATABASE=${PGDATABASE}
# DB_USERNAME=${PGUSER}
# DB_PASSWORD=${PGPASSWORD}

# ===========================================
# MONGODB SETTINGS (Secondary Database)
# ===========================================
# Set these after adding MongoDB service to Railway:
DB_MONGO_DATABASE=luxe_hair_catalog
# DB_MONGO_HOST=${MONGODB_HOST}
# DB_MONGO_PORT=${MONGODB_PORT}
# DB_MONGO_USERNAME=${MONGODB_USERNAME}
# DB_MONGO_PASSWORD=${MONGODB_PASSWORD}
# MONGODB_URI=${MONGO_URL}

# ===========================================
# CACHE & SESSION SETTINGS
# ===========================================
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_SAME_SITE=lax

# After adding Redis service, update these:
# CACHE_DRIVER=redis
# SESSION_DRIVER=redis
# REDIS_HOST=${REDIS_HOST}
# REDIS_PASSWORD=${REDIS_PASSWORD}
# REDIS_PORT=${REDIS_PORT}

# ===========================================
# QUEUE SETTINGS
# ===========================================
QUEUE_CONNECTION=sync

# After adding Redis, change to:
# QUEUE_CONNECTION=redis

# ===========================================
# MAIL CONFIGURATION
# ===========================================
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@luxehair.com
MAIL_FROM_NAME="Luxe Hair Studio"

# ===========================================
# FILE STORAGE
# ===========================================
FILESYSTEM_DISK=public

# ===========================================
# SECURITY SETTINGS
# ===========================================
SANCTUM_STATEFUL_DOMAINS=hair-salon-production.up.railway.app
SESSION_DOMAIN=.railway.app

# ===========================================
# LOGGING
# ===========================================
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# ===========================================
# BROADCASTING (Optional)
# ===========================================
BROADCAST_DRIVER=log

# ===========================================
# OPTIMIZATION SETTINGS
# ===========================================
OPTIMIZE_CLEAR_CACHE=true
VIEW_COMPILED_PATH=/tmp/views
SESSION_STORE=file