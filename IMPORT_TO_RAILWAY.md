# Import MongoDB Data to Railway

## Your Local Data Files
- `mongodb_services_export.json` - 20 services
- `mongodb_deals_export.json` - 10 deals

## Railway MongoDB Connection Details
```
Host: mongodb.railway.internal (or yamabiko.proxy.rlwy.net for external)
Port: 27017 (or 40669 for external)
Username: mongo
Password: NHFMjojQXmtUGyxiCJxmeiwKGvAhVOBo
Database: luxe_hair_catalog
```

---

## METHOD 1: Using MongoDB Compass (GUI - EASIEST)

1. **Download MongoDB Compass**: https://www.mongodb.com/try/download/compass

2. **Connect to Railway MongoDB**:
   - Connection String: `mongodb://mongo:NHFMjojQXmtUGyxiCJxmeiwKGvAhVOBo@yamabiko.proxy.rlwy.net:40669/luxe_hair_catalog`
   
3. **Import Services**:
   - Click on `luxe_hair_catalog` database
   - Click "Create Collection" → name it `services`
   - Click on `services` collection
   - Click "ADD DATA" → "Import JSON or CSV file"
   - Select `mongodb_services_export.json`
   - Click "Import"

4. **Import Deals**:
   - Click "Create Collection" → name it `deals`
   - Click on `deals` collection
   - Click "ADD DATA" → "Import JSON or CSV file"
   - Select `mongodb_deals_export.json`
   - Click "Import"

5. **Verify**:
   - Check that `services` has 20 documents
   - Check that `deals` has 10 documents

---

## METHOD 2: Using mongoimport CLI

### Step 1: Install MongoDB Tools
Download from: https://www.mongodb.com/try/download/database-tools

### Step 2: Import Services
```powershell
mongoimport --uri="mongodb://mongo:NHFMjojQXmtUGyxiCJxmeiwKGvAhVOBo@yamabiko.proxy.rlwy.net:40669/luxe_hair_catalog" --collection=services --file=mongodb_services_export.json --jsonArray
```

### Step 3: Import Deals
```powershell
mongoimport --uri="mongodb://mongo:NHFMjojQXmtUGyxiCJxmeiwKGvAhVOBo@yamabiko.proxy.rlwy.net:40669/luxe_hair_catalog" --collection=deals --file=mongodb_deals_export.json --jsonArray
```

---

## METHOD 3: Using Railway MongoDB Data Tab

1. Go to Railway Dashboard
2. Click on your MongoDB service
3. Click "Data" tab
4. Click "Add Collection" → name it `services`
5. Click "Insert Document"
6. Copy/paste the JSON from `mongodb_services_export.json`
7. Repeat for each service (manual, tedious)

**Note: This method is manual and tedious. Use Method 1 or 2 instead.**

---

## After Import - Verify

1. Visit your Railway app: https://hair-salon-production.up.railway.app/
2. The services should now appear on the homepage
3. Navigate to /services to see all services
4. Check that deals appear (if you have a deals page)

---

## Troubleshooting

**If import fails with "authentication failed":**
- Make sure you're using the EXTERNAL connection URL (yamabiko.proxy.rlwy.net)
- Check that the password is correct: `NHFMjojQXmtUGyxiCJxmeiwKGvAhVOBo`

**If import succeeds but website still shows no data:**
- Clear Laravel cache on Railway
- Go to Railway → Your Service → Settings
- Add environment variable: `CACHE_CLEAR=1`
- Wait for redeploy, then remove the variable

**If collections already exist:**
- Drop them first using MongoDB Compass or:
```javascript
// In Railway MongoDB Data tab, run:
db.services.drop()
db.deals.drop()
```
