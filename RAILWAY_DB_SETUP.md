# Database Setup Commands for Railway

## 🗄️ Run these commands in order using Railway CLI:

### 1. Check Database Connection
```bash
railway run php artisan tinker
# In tinker, run: DB::connection()->getPdo()
# Press Ctrl+C to exit tinker
```

### 2. Run Database Migrations
```bash
railway run php artisan migrate --force
```

### 3. Check Available Seeders
```bash
railway run php artisan db:seed --class=DatabaseSeeder --force
```

### 4. Run Specific Seeders (if available)
```bash
# Check what seeders exist first
railway run ls database/seeders/

# Then run common seeders:
railway run php artisan db:seed --class=UserSeeder --force
railway run php artisan db:seed --class=ServiceSeeder --force
railway run php artisan db:seed --class=CategorySeeder --force
railway run php artisan db:seed --class=BasicDataSeeder --force
```

### 5. Create Admin User (if needed)
```bash
railway run php artisan tinker
# In tinker, create admin user:
# User::create(['name' => 'Admin', 'email' => 'admin@luxehair.com', 'password' => Hash::make('password'), 'role' => 'admin']);
```

### 6. Check Tables and Data
```bash
railway run php artisan tinker
# In tinker, check tables:
# DB::select('SHOW TABLES')
# User::count()
# Service::count() (if Service model exists)
```

## 🔧 Alternative: One-Line Setup
```bash
railway run php artisan migrate --force && php artisan db:seed --force
```