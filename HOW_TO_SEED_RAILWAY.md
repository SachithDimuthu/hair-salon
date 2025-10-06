# Seed Railway MongoDB - Easy Method

## Quick Fix for 500 Error

Your Railway MongoDB is empty. We need to populate it with services data.

## Method 1: Run Seeder Script on Railway (Easiest)

### Step 1: The script is ready
I've created `seed_railway_mongodb.php` which will populate your Railway MongoDB with 20 services.

### Step 2: Run it on Railway

**Option A: Using Railway CLI**
```bash
# Install Railway CLI (if not installed)
npm i -g @railway/cli

# Login
railway login

# Link to your project
railway link

# Run the seeder
railway run php seed_railway_mongodb.php
```

**Option B: Add as a one-time deployment command**

1. Go to Railway dashboard
2. Click on your Laravel service
3. Go to "Settings" tab
4. Find "Deploy Command" or create a one-time deployment
5. Add this command:
   ```
   php seed_railway_mongodb.php && php artisan serve --host=0.0.0.0 --port=$PORT
   ```
6. Redeploy

## Method 2: Run Locally (Points to Railway MongoDB)

### Step 1: Update your local .env temporarily

```env
DB_MONGO_HOST=<your-railway-mongo-host>
DB_MONGO_PORT=<your-railway-mongo-port>
DB_MONGO_DATABASE=<your-railway-database-name>
DB_MONGO_USERNAME=<your-railway-username>
DB_MONGO_PASSWORD=<your-railway-password>
```

### Step 2: Run the seeder locally
```bash
php seed_railway_mongodb.php
```

### Step 3: Revert your .env back to local settings

## Method 3: Manual MongoDB Compass Import (Most Reliable)

### Step 1: Export from local MongoDB

Run this locally:
```bash
php -r "require 'vendor/autoload.php'; \$app = require 'bootstrap/app.php'; \$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); \$services = DB::connection('mongodb')->table('services')->get(); file_put_contents('services_export.json', json_encode(\$services, JSON_PRETTY_PRINT));"
```

This creates `services_export.json`

### Step 2: Install MongoDB Compass
Download from: https://www.mongodb.com/try/download/compass

### Step 3: Connect to Railway MongoDB
Use your `MONGO_URL` from Railway variables

### Step 4: Import the JSON
1. Create/open database (the name from `DB_MONGO_DATABASE`)
2. Create collection "services"
3. Click "ADD DATA" → "Import JSON or CSV"
4. Select `services_export.json`
5. Import!

## Which Method Should You Use?

- **Method 1**: Best if you have Railway CLI installed
- **Method 2**: Quick if you want to run from your computer
- **Method 3**: Most reliable, uses GUI tool

## After Seeding

1. Visit: https://hair-salon-production.up.railway.app/
2. Homepage should load! ✅
3. Services should be visible ✅
4. Check /services page - should show 20 services ✅

## Tell Me

Which method do you want to try?
1. "Railway CLI" (Method 1)
2. "Run locally pointing to Railway" (Method 2)
3. "MongoDB Compass" (Method 3)
4. "Just add more services to the seeder script first" (I can add all 37)

Let me know and I'll guide you through it!
