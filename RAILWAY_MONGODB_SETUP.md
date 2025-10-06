# Railway Production Environment Variables

## Required Environment Variables for Production

Copy these to your Railway project environment variables:

```bash
# Application
APP_NAME="Luxe Hair Studio"
APP_ENV=production
APP_KEY=base64:GluQIaHpPcpk8ikyE6nTihsvO1ySpv5AY1x55dETb38=
APP_DEBUG=false
APP_TIMEZONE=UTC
APP_URL=https://hair-salon-production.up.railway.app
ASSET_URL=https://hair-salon-production.up.railway.app

# Database - SQLite for authentication
DB_CONNECTION=sqlite
DATABASE_URL=

# MongoDB Configuration (for services and deals)
DB_MONGO_CONNECTION=mongodb
DB_MONGO_HOST=${{MONGO_HOST}}
DB_MONGO_PORT=${{MONGO_PORT}}
DB_MONGO_DATABASE=${{MONGO_DATABASE}}
DB_MONGO_USERNAME=${{MONGO_USERNAME}}
DB_MONGO_PASSWORD=${{MONGO_PASSWORD}}

# Cache & Sessions
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_SAME_SITE=lax
SESSION_DOMAIN=.railway.app

# Queue & Filesystem
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=public

# Security
SANCTUM_STATEFUL_DOMAINS=hair-salon-production.up.railway.app

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error

# Optimization
OPTIMIZE_CLEAR_CACHE=true
VIEW_COMPILED_PATH=/tmp/views

# Mail (optional)
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@luxe-hair-studio.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## MongoDB Setup on Railway

Your MongoDB service should provide these variables:
- `MONGO_HOST` - MongoDB host URL
- `MONGO_PORT` - MongoDB port (usually 27017)
- `MONGO_DATABASE` - Database name (e.g., luxe_hair_catalog)
- `MONGO_USERNAME` - MongoDB username
- `MONGO_PASSWORD` - MongoDB password

## Important Notes

1. **Database Strategy**: 
   - SQLite: Used for authentication (users, sessions)
   - MongoDB: Used for services and deals catalog

2. **The models are configured**:
   - Service model: `protected $connection = 'mongodb'`
   - Deal model: `protected $connection = 'mongodb'`

3. **Make sure** your Railway MongoDB service contains:
   - 37 services with proper image paths
   - 10 deals
   
4. **Deploy Command**: 
   Railway should run: `php artisan optimize:clear && php artisan config:cache`

## Troubleshooting

If you see "Something Went Wrong (500 error)":
1. Check Railway logs: `railway logs`
2. Verify MongoDB connection variables are set
3. Ensure SQLite database file exists in `/app/database/database.sqlite`
4. Run migrations if needed: `php artisan migrate --force`
