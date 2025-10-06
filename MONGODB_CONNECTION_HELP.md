# Railway MongoDB Connection Troubleshooting

## Try these connection strings in MongoDB Compass:

### Option 1: With authSource
```
mongodb://mongo:NHFMjojQXmtUGyxiCJxmeiwKGvAhVOBo@yamabiko.proxy.rlwy.net:40669/luxe_hair_catalog?authSource=admin
```

### Option 2: Connect to admin database first
```
mongodb://mongo:NHFMjojQXmtUGyxiCJxmeiwKGvAhVOBo@yamabiko.proxy.rlwy.net:40669/admin
```

### Option 3: Manual connection in Compass
Instead of pasting the URI, try filling out the form manually:

1. Open MongoDB Compass
2. Click "Fill in connection fields individually"
3. Enter these details:

**General Tab:**
- Hostname: `yamabiko.proxy.rlwy.net`
- Port: `40669`

**Authentication Tab:**
- Username: `mongo`
- Password: `NHFMjojQXmtUGyxiCJxmeiwKGvAhVOBo`
- Authentication Database: `admin`

**Advanced Tab:**
- Default Database: `luxe_hair_catalog`

4. Click "Connect"

---

## Get Current Railway MongoDB Connection URL

1. Go to Railway Dashboard: https://railway.app/
2. Click on your MongoDB service
3. Click "Variables" tab
4. Look for `MONGO_PUBLIC_URL` or `MONGO_URL`
5. Copy the EXACT URL shown there
6. Use that URL in MongoDB Compass

---

## Alternative: Use Railway's MongoDB Data Tab

If Compass won't connect, you can import directly via Railway:

1. Go to Railway Dashboard
2. Click your MongoDB service
3. Click "Data" tab
4. You should see the database interface
5. Click "Create Database" → name: `luxe_hair_catalog` (if not exists)
6. Click on the database
7. Click "Create Collection" → name: `services`
8. Click "Insert Document"
9. Paste the content from `mongodb_services_export.json`
10. Click "Insert"

(Repeat for deals collection)

---

## Test Connection from Command Line

Try this in PowerShell to verify the connection:

```powershell
mongosh "mongodb://mongo:NHFMjojQXmtUGyxiCJxmeiwKGvAhVOBo@yamabiko.proxy.rlwy.net:40669/admin"
```

If this works, you can import directly from command line:

```powershell
mongoimport --uri="mongodb://mongo:NHFMjojQXmtUGyxiCJxmeiwKGvAhVOBo@yamabiko.proxy.rlwy.net:40669/luxe_hair_catalog?authSource=admin" --collection=services --file=mongodb_services_export.json --jsonArray
```
