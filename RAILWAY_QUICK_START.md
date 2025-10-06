# Railway Setup - Quick Start Checklist

## ✅ Pre-Flight Checklist

Before you start, make sure you have:
- [ ] Railway account (https://railway.app)
- [ ] Access to your hair-salon project
- [ ] MongoDB service running OR MongoDB Atlas account

---

## 🚀 5-Minute Setup (Follow in Order)

### 1️⃣ Open Railway Dashboard
```
→ Go to: https://railway.app/
→ Login with GitHub
→ Click on "hair-salon-production" project
```

### 2️⃣ Locate Your Services
You should see these services:
```
✅ Your Laravel App (main application)
? MongoDB or MySQL database
```

**Question**: Do you see a MongoDB service?
- **YES** → Continue to Step 3
- **NO** → You need to add MongoDB first (see bottom of this file)

### 3️⃣ Get MongoDB Credentials

**Click on MongoDB service** → Variables tab

Copy these values (example):
```
MONGOHOST: monorail.proxy.rlwy.net
MONGOPORT: 54321
MONGOUSER: mongo  
MONGOPASSWORD: secretpassword123
MONGODATABASE: railway
```

### 4️⃣ Update Laravel App Variables

**Click on Laravel app service** → Variables tab

**CHANGE THIS VARIABLE:**
```
DB_CONNECTION = mysql  ❌ DELETE THIS VALUE
              ↓
DB_CONNECTION = sqlite  ✅ CHANGE TO THIS
```

**ADD THESE NEW VARIABLES:**
Click "+ New Variable" for each:

```
Variable 1: DB_MONGO_CONNECTION = mongodb
Variable 2: DB_MONGO_HOST = (paste MONGOHOST from step 3)
Variable 3: DB_MONGO_PORT = (paste MONGOPORT from step 3)
Variable 4: DB_MONGO_DATABASE = (paste MONGODATABASE from step 3)
Variable 5: DB_MONGO_USERNAME = (paste MONGOUSER from step 3)
Variable 6: DB_MONGO_PASSWORD = (paste MONGOPASSWORD from step 3)
```

### 5️⃣ Deploy & Verify

```
→ Railway will auto-redeploy (wait 2-3 minutes)
→ Visit: https://hair-salon-production.up.railway.app/
→ Check: Homepage loads ✅
→ Check: Services page shows 37 services ✅
```

---

## 🎯 What You're Looking For in Railway

### Your Laravel App Variables Tab Should Look Like:

```
APP_NAME = Luxe Hair Studio
APP_ENV = production
APP_DEBUG = false
APP_URL = https://hair-salon-production.up.railway.app
DB_CONNECTION = sqlite  ← IMPORTANT!
DB_MONGO_CONNECTION = mongodb  ← ADD THIS
DB_MONGO_HOST = your-mongo-host  ← ADD THIS
DB_MONGO_PORT = 27017  ← ADD THIS
DB_MONGO_DATABASE = luxe_hair_catalog  ← ADD THIS
DB_MONGO_USERNAME = your-username  ← ADD THIS
DB_MONGO_PASSWORD = your-password  ← ADD THIS
... (other variables)
```

---

## 📸 What to Share If You Need Help

1. **Screenshot 1**: Railway project dashboard (showing all services)
2. **Screenshot 2**: MongoDB service variables (blur password!)
3. **Screenshot 3**: Laravel app variables list
4. **Screenshot 4**: Any error messages from deployment logs

Paste these in the chat and I'll guide you through!

---

## 🆘 Don't Have MongoDB Service?

### Add MongoDB to Railway:

```
1. In your Railway project
2. Click "+ New" button
3. Select "Database"
4. Choose "MongoDB"
5. Wait 1-2 minutes for provisioning
6. Click on MongoDB → Variables tab
7. Copy the credentials
8. Go back to Step 4 above
```

---

## 🔍 How to Check If It Worked

### Test 1: Homepage
```
Visit: https://hair-salon-production.up.railway.app/
Expected: Homepage loads, shows services
Error 500? → Something wrong with MongoDB connection
```

### Test 2: Services Page
```
Visit: https://hair-salon-production.up.railway.app/services
Expected: Shows 37 services with images
Shows 6 services? → DB_CONNECTION might still be "mysql"
```

### Test 3: Browser Console
```
Press F12 → Console tab
Expected: No Alpine.js warnings
See warnings? → Old deployment, wait for new deploy
```

---

## 💡 Pro Tips

1. **Variables are case-sensitive** - type them exactly as shown
2. **Railway auto-deploys** - no need to manually trigger deploy
3. **Wait 2-3 minutes** - deployment takes time
4. **Check logs** - Deployments tab → View Logs for errors
5. **Hard refresh** - Press Ctrl+Shift+R after deploy

---

## 📞 Ready for Next Steps?

Once you're in Railway dashboard, tell me:
1. "I can see MongoDB service" or "No MongoDB service"
2. "I'm in the Variables tab" 
3. Share screenshot if stuck

Let's get this fixed! 🚀
