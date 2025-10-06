# Railway Deployment Fix - Step by Step

## Issue Summary
1. ✅ Local site works perfectly (37 MongoDB services with images)
2. ❌ Production shows 500 error on homepage
3. ❌ Production /services page shows only 6 MySQL services (should show 37 MongoDB services)
4. ✅ Alpine.js duplicate loading warning (FIXED locally)

## Root Cause
The Railway environment is configured for MySQL (`DB_CONNECTION=mysql`) but the app now uses:
- **SQLite** for authentication/users
- **MongoDB** for services and deals

## Solution Steps

### Step 1: Update Railway Environment Variables

Log into Railway dashboard and update these variables:

```bash
# Change this from mysql to sqlite
DB_CONNECTION=sqlite

# Add MongoDB connection variables
DB_MONGO_CONNECTION=mongodb
DB_MONGO_HOST=<your-mongodb-host>
DB_MONGO_PORT=27017
DB_MONGO_DATABASE=luxe_hair_catalog
DB_MONGO_USERNAME=<your-mongodb-username>
DB_MONGO_PASSWORD=<your-mongodb-password>
```

### Step 2: Ensure MongoDB Data Exists

Your Railway MongoDB should have:
- ✅ **37 services** with fields: name, slug, category, description, price, image, active, visibility
- ✅ **10 deals** with proper data
- ✅ All service images pointing to `images/Services/...`

### Step 3: Deploy the Latest Code

The latest commit includes:
- ✅ Service model configured for MongoDB
- ✅ Deal model configured for MongoDB  
- ✅ All views updated for MongoDB field names
- ✅ Alpine.js duplicate loading fixed
- ✅ CSP headers updated for fonts

Just push and Railway will auto-deploy:
```bash
git push origin main
```

### Step 4: Verify SQLite Database

Railway needs the SQLite database file for authentication. Make sure:
1. The file `database/database.sqlite` exists in the repo
2. It's committed to git
3. Migrations run successfully on Railway

### Step 5: Check Railway Logs

After deployment, monitor logs:
```bash
railway logs
```

Look for:
- ✅ MongoDB connection successful
- ✅ Migrations completed
- ✅ No 500 errors
- ✅ Services loading from MongoDB

## Expected Result

After these changes:
- ✅ Homepage loads successfully with MongoDB services
- ✅ /services page shows all 37 MongoDB services with images
- ✅ No Alpine.js warnings
- ✅ All images display correctly
- ✅ No 500 errors

## MongoDB Connection String Format

If Railway provides a single MongoDB URI, you can use:
```bash
# Instead of individual variables, use:
MONGODB_URI=mongodb://username:password@host:port/database
```

Then in `config/database.php`, the MongoDB connection will parse this automatically.

## Troubleshooting

### If homepage still shows 500:
1. Check `storage/logs/laravel.log` on Railway
2. Verify MongoDB credentials are correct
3. Ensure database.sqlite file exists

### If services page shows MySQL services:
1. Verify `DB_CONNECTION=sqlite` (not mysql)
2. Check Service model has `protected $connection = 'mongodb'`
3. Clear config cache: `php artisan config:clear`

### If images don't show:
1. Verify MongoDB services have `image` field set
2. Check image paths: `images/Services/Haircut.jpg`
3. Ensure images exist in `public/images/Services/` directory
