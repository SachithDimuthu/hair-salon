# Railway Dashboard Guide - Step by Step

## 🎯 Goal
Update environment variables to fix the 500 error and enable MongoDB services on your production site.

---

## Step 1: Log into Railway

1. Go to: **https://railway.app/**
2. Click **"Login"** (top right)
3. Sign in with your GitHub account

---

## Step 2: Open Your Project

1. You should see your project: **"hair-salon-production"**
2. Click on it to open

You'll see:
- Your Laravel app service
- Possibly a MySQL service
- Possibly a MongoDB service

---

## Step 3: Find Your MongoDB Service

### Option A: If you have MongoDB service in Railway

1. Look for a service labeled **"MongoDB"** or similar
2. Click on it
3. Go to **"Variables"** tab
4. You'll see connection details like:
   - `MONGO_URL` or `MONGODB_URL`
   - `MONGOHOST`
   - `MONGOPORT`
   - `MONGOUSER`
   - `MONGOPASSWORD`
   - `MONGODATABASE`

**Copy these values** - you'll need them!

### Option B: If you're using MongoDB Atlas (External)

1. Go to: **https://cloud.mongodb.com/**
2. Log into your MongoDB Atlas account
3. Click **"Connect"** on your cluster
4. Choose **"Connect your application"**
5. Copy the connection string (looks like):
   ```
   mongodb+srv://username:password@cluster.mongodb.net/database
   ```

### Option C: If you don't have MongoDB yet

You need to add a MongoDB service:

1. In Railway project, click **"+ New"**
2. Select **"Database"**
3. Choose **"MongoDB"**
4. Wait for it to provision (1-2 minutes)
5. Click on the MongoDB service → **"Variables"** tab
6. Copy the connection details

---

## Step 4: Update Your Laravel App Variables

1. Go back to your project dashboard
2. Click on your **Laravel app service** (not MongoDB)
3. Click the **"Variables"** tab
4. You'll see a list of environment variables

---

## Step 5: Change DB_CONNECTION Variable

1. Find the variable: **`DB_CONNECTION`**
2. Current value is probably: `mysql`
3. Click on it to edit
4. Change to: **`sqlite`**
5. Click **"Save"** or press Enter

---

## Step 6: Add MongoDB Variables

Now add these new variables by clicking **"+ New Variable"**:

### Variable 1:
- **Name**: `DB_MONGO_CONNECTION`
- **Value**: `mongodb`

### Variable 2:
- **Name**: `DB_MONGO_HOST`
- **Value**: (paste your MongoDB host)
  - From Railway MongoDB: Use the `MONGOHOST` value
  - From Atlas: Extract host from connection string (the part between `@` and `/`)

### Variable 3:
- **Name**: `DB_MONGO_PORT`
- **Value**: `27017` (or your MongoDB port)

### Variable 4:
- **Name**: `DB_MONGO_DATABASE`
- **Value**: `luxe_hair_catalog` (or your database name)

### Variable 5:
- **Name**: `DB_MONGO_USERNAME`
- **Value**: (paste your MongoDB username)

### Variable 6:
- **Name**: `DB_MONGO_PASSWORD`
- **Value**: (paste your MongoDB password)

---

## Step 7: Save and Deploy

1. After adding all variables, Railway will ask to **redeploy**
2. Click **"Deploy"** or it will auto-deploy
3. Wait 2-3 minutes for deployment to complete

---

## Step 8: Check Deployment Logs

1. While deploying, click **"Deployments"** tab
2. Click on the latest deployment (top one)
3. Click **"View Logs"**
4. Watch for:
   - ✅ "Build successful"
   - ✅ "Deployment successful"
   - ❌ Any errors (let me know if you see errors!)

---

## Step 9: Test Your Site

1. Go to: **https://hair-salon-production.up.railway.app/**
2. Homepage should load (no 500 error!) ✅
3. Click **"Services"** menu
4. Should see **37 services** with images ✅

---

## 🆘 Need Help? Share These Screenshots

If you get stuck, take screenshots of:

1. **Railway Project Dashboard** - showing all services
2. **MongoDB Variables** - (blur passwords!)
3. **Laravel App Variables** - your current variables list
4. **Deployment Logs** - if there are errors

Then I can help you troubleshoot!

---

## 📝 Quick Reference

Your MongoDB credentials should look like:

### Example from Railway MongoDB:
```
MONGOHOST=monorail.proxy.rlwy.net
MONGOPORT=12345
MONGOUSER=mongo
MONGOPASSWORD=abc123xyz
MONGODATABASE=railway
```

### Example from MongoDB Atlas:
```
Connection String: mongodb+srv://user:pass@cluster0.abc123.mongodb.net/mydb

Extract to:
MONGO_HOST=cluster0.abc123.mongodb.net
MONGO_PORT=27017
MONGO_USERNAME=user
MONGO_PASSWORD=pass
MONGO_DATABASE=mydb
```

---

## ✅ Expected Result

After setup:
- ✅ Homepage loads successfully
- ✅ Shows MongoDB services (not MySQL)
- ✅ 37 services visible with images
- ✅ No 500 errors
- ✅ No Alpine.js warnings

---

## Common Issues & Solutions

### Issue 1: "Can't find MongoDB service"
**Solution**: You need to add MongoDB database to your Railway project first

### Issue 2: "Still seeing 500 error"
**Solution**: Check deployment logs for specific error message

### Issue 3: "Still showing 6 services (MySQL)"
**Solution**: Make sure `DB_CONNECTION=sqlite` (not `mysql`)

### Issue 4: "MongoDB connection failed"
**Solution**: Double-check your MongoDB credentials are correct

---

## 🎬 Video Tutorial Alternative

If you prefer video, search YouTube for:
- "Railway add MongoDB to Laravel"
- "Railway environment variables tutorial"

---

**Ready to start?** Go to https://railway.app/ and let me know what you see! 🚀
