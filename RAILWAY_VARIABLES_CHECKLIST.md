# Railway Environment Variables - Quick Setup

## ⚠️ CRITICAL: Update These Variables in Railway Dashboard

Go to: https://railway.app → Your Project → Variables

### 1. Database Connection (CHANGE THIS!)
```
DB_CONNECTION=sqlite
```
**Current value in Railway**: `mysql` ❌  
**Should be**: `sqlite` ✅

### 2. MongoDB Connection (ADD THESE!)

```
DB_MONGO_CONNECTION=mongodb
DB_MONGO_HOST=your-mongodb-host
DB_MONGO_PORT=27017
DB_MONGO_DATABASE=luxe_hair_catalog
DB_MONGO_USERNAME=your-username
DB_MONGO_PASSWORD=your-password
```

**Get these values from**:
- Railway MongoDB service dashboard
- Or from your MongoDB Atlas connection string
- Or from your external MongoDB provider

### 3. Quick Verification Checklist

After updating variables and redeploying:

- [ ] Visit https://hair-salon-production.up.railway.app/
- [ ] Homepage loads without 500 error
- [ ] Services section shows MongoDB services (should see multiple services)
- [ ] Visit https://hair-salon-production.up.railway.app/services
- [ ] Should see 37 services (not just 6)
- [ ] Images should display for all services
- [ ] No Alpine.js console warnings

### 4. If Issues Persist

Check Railway logs:
```bash
railway logs
```

Look for errors related to:
- MongoDB connection
- Database migrations  
- Missing environment variables

### 5. MongoDB Data Requirements

Your MongoDB database needs:
- Collection: `services` (37 documents)
- Collection: `deals` (10 documents)

Each service should have:
```json
{
  "name": "Service Name",
  "slug": "service-name",
  "category": "Hair",
  "description": "Description",
  "price": 1500,
  "image": "images/Services/Haircut.jpg",
  "active": true,
  "visibility": "public"
}
```

---

## 🚀 After Setup

1. Save environment variables in Railway
2. Railway will auto-redeploy
3. Wait 2-3 minutes for deployment
4. Visit the site and verify
5. All 37 MongoDB services should be visible! ✅
