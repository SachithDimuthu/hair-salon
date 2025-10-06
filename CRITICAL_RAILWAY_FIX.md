# CRITICAL FIX - Add Missing Railway Variable

## Issue Found
Your MongoDB seeder can't run because you're missing: **`DB_MONGO_DATABASE`**

## Quick Fix

### Go to Railway Dashboard → Your Laravel App → Variables

**Add this variable:**
```
Name: DB_MONGO_DATABASE
Value: railway
```

(Use "railway" as the database name, or whatever database name your MongoDB service uses)

### How to Find the Correct Database Name:

1. Go to your Railway MongoDB service
2. Look for a variable like:
   - `MONGODATABASE` or
   - `MONGO_DATABASE` or
   - Check the `MONGO_URL` - it's the last part after the `/`

Example MONGO_URL:
```
mongodb://mongo:password@host:27017/railway
                                      ^^^^^^^^ this is the database name
```

## After Adding the Variable

Railway will automatically redeploy and:
1. Run migrations
2. **Seed 20 MongoDB services**
3. Start the server
4. ✅ Site works!

---

**Add the variable now and tell me when Railway starts redeploying!**
