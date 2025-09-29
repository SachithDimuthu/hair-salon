# MongoDB Installation and Setup Guide

## Step 1: Install MongoDB PHP Extension

### For XAMPP on Windows:

1. **Download MongoDB PHP Extension:**
   - Go to https://pecl.php.net/package/mongodb
   - Download the appropriate version for your PHP version
   - For XAMPP, typically you need the Thread Safe (TS) version

2. **Install the extension:**
   - Extract `php_mongodb.dll` to your XAMPP PHP extensions directory
   - Usually: `C:\xampp\php\ext\`

3. **Enable the extension:**
   - Edit `C:\xampp\php\php.ini`
   - Add this line: `extension=mongodb`
   - Restart Apache

### Alternative: Using Composer (requires MongoDB extension):
```powershell
composer require mongodb/mongodb
```

## Step 2: Install MongoDB Server

1. **Download MongoDB Community Server:**
   - Go to https://www.mongodb.com/try/download/community
   - Download for Windows
   - Install with default settings

2. **Start MongoDB service:**
   - MongoDB should start automatically after installation
   - Or run: `net start MongoDB`

## Step 3: Verify Installation

```powershell
# Check if MongoDB extension is loaded
php -m | grep mongodb

# Check if MongoDB is running
mongo --version
# or
mongosh --version
```

## Step 4: Run Normalization

Once MongoDB is properly installed:

```powershell
# Run the normalization command
php artisan services:normalize --dry-run
php artisan services:normalize

# Or use tinker (see normalize_services_tinker.txt)
php artisan tinker
# Then copy/paste the normalization script
```

## Temporary Workaround: Switch to MySQL for Testing

If you want to test the code structure without MongoDB:

1. **Update .env:**
   ```properties
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=luxe_hair_studio
   DB_USERNAME=root
   DB_PASSWORD=
   ```

2. **Update Service model:**
   ```php
   protected $connection = 'mysql'; // instead of 'mongodb'
   protected $table = 'services'; // instead of $collection
   ```

3. **Create MySQL migration:**
   ```powershell
   php artisan make:migration create_services_table
   ```

4. **Run migration and seeder:**
   ```powershell
   php artisan migrate
   php artisan db:seed --class=ServiceSeeder
   ```

## MongoDB vs MySQL Differences

**MongoDB (Current Implementation):**
- Document-based storage
- Arrays and objects stored natively
- No migrations needed
- Uses `$collection` property
- Uses `MongoDB\Laravel\Eloquent\Model`

**MySQL (Fallback):**
- Relational database
- JSON columns for arrays/objects
- Requires migrations
- Uses `$table` property  
- Uses `Illuminate\Database\Eloquent\Model`

## Next Steps

1. Install MongoDB PHP extension
2. Run normalization command
3. Test API endpoints
4. Add Sanctum authentication
5. Implement booking logic