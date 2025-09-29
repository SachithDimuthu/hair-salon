# MongoDB Installation Guide for Windows

## Step 1: Download MongoDB Community Edition

1. Visit: https://www.mongodb.com/try/download/community
2. Select:
   - Version: 8.0.3 (Current)
   - Platform: Windows
   - Package: msi

## Step 2: Install MongoDB

1. Run the downloaded .msi installer
2. Choose "Complete" installation
3. Install MongoDB as a Windows Service (recommended)
4. Install MongoDB Compass (GUI tool) - check the box

## Step 3: Verify Installation

Open PowerShell as Administrator and run:
```powershell
# Check if MongoDB service is running
Get-Service -Name MongoDB

# Test MongoDB connection
mongo --eval "db.adminCommand('ismaster')"
```

## Step 4: Start MongoDB Service (if not running)

```powershell
# Start MongoDB service
Start-Service -Name MongoDB

# Or using net command
net start MongoDB
```

## Default Connection Details

- Host: 127.0.0.1
- Port: 27017
- Connection String: mongodb://127.0.0.1:27017

## MongoDB Compass

MongoDB Compass should be installed automatically. You can:
1. Open MongoDB Compass
2. Connect to: mongodb://127.0.0.1:27017
3. Create database: luxe_hair_studio

---

**Please install MongoDB following these steps and then run: `mongo --version` to confirm installation.**