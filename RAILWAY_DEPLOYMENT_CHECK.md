# Railway Deployment Diagnostics

## Current Status: 500 Error on Registration

### What to Check in Railway Dashboard:

1. **Go to Railway Deployment Logs:**
   - Dashboard → hair-salon service → Deployments → Latest → View Logs
   
2. **Look for these sections:**

   ✅ **BUILD LOGS** (already successful):
   ```
   Successfully Built!
   Build time: 136.28 seconds
   ```

   ❓ **START LOGS** (need to verify):
   ```
   bash railway-start.sh
   🚀 Starting Luxe Hair Studio...
   📄 Running database migrations...
   Migration table created successfully.
   Migrating: ...
   ```

3. **Common Error Patterns to Look For:**

   🔴 **Database Connection Error:**
   ```
   SQLSTATE[HY000] [2002] Connection refused
   SQLSTATE[HY000] [1045] Access denied
   ```
   → MySQL database not properly linked

   🔴 **APP_KEY Error:**
   ```
   No application encryption key has been specified
   ```
   → APP_KEY not set or invalid

   🔴 **Migration Error:**
   ```
   SQLSTATE[42S01]: Base table or view already exists
   Syntax error or access violation
   ```
   → Migration issues

   🔴 **File Not Found:**
   ```
   railway-start.sh: No such file or directory
   ```
   → Start script not found

---

## Quick Test Endpoints:

### 1. Test if app is running at all:
```
GET https://hair-salon-production.up.railway.app/api
```

Expected: `{"message":"API is running"}`

If this fails → App didn't start properly

### 2. Test debug endpoint:
```
GET https://hair-salon-production.up.railway.app/api/debug/auth-status
```

Expected:
```json
{
  "app_key_set": true,
  "database_connection": "mysql",
  "users_table_exists": true,
  "users_count": 0,
  "sanctum_config": true
}
```

### 3. Test health check:
```
GET https://hair-salon-production.up.railway.app/health-check-diagnostics-2024
```

This will show full system diagnostics

---

## Next Steps Based on Logs:

### If logs show "railway-start.sh not found":
→ The start command in nixpacks.toml is wrong

### If logs show database connection errors:
→ MySQL service not linked or wrong credentials

### If logs show migrations failed:
→ Share the specific migration error

### If logs show nothing (app not starting):
→ Check the start command in Railway dashboard

---

## Manual Migration Command (if needed):

If automatic migrations aren't working, try:

```powershell
# DON'T use railway run from local machine - it won't work!
# Instead, add a one-time endpoint to run migrations
```

---

## Alternative: Use Procfile Instead

If railway-start.sh isn't being found, we can use the Procfile which already works:

The Procfile already has:
```
web: php artisan migrate --force && php artisan config:cache && ...
```

To use Procfile instead of nixpacks start command, remove the `[start]` section from nixpacks.toml.

