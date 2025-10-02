# Azure Portal GUI Deployment Tutorial for Luxe Hair Studio

## 🎯 Overview

This tutorial will guide you through deploying your Laravel-based hair salon booking system to Microsoft Azure using the **Azure Portal web interface** (GUI). No command line required!

## 📋 Prerequisites

Before starting, ensure you have:
1. **Azure Account**: [Create free account](https://azure.microsoft.com/free/) - $200 free credit
2. **Web Browser**: Chrome, Firefox, or Edge
3. **GitHub Account**: For code deployment
4. **Your Laravel Project**: Ready from previous local preparation

## 🚀 Step 1: Create Azure Resource Group

### 1.1 Access Azure Portal
1. Go to [https://portal.azure.com](https://portal.azure.com)
2. Sign in with your Azure account
3. You'll see the Azure Portal dashboard

### 1.2 Create Resource Group
1. Click **"Resource groups"** in the left sidebar (or search for it in the top search bar)
2. Click **"+ Create"** button
3. Fill in the details:
   - **Subscription**: Select your subscription (usually "Free Trial" or "Pay-As-You-Go")
   - **Resource group name**: `luxe-hair-studio-rg`
   - **Region**: Choose closest to your users (e.g., "East US", "West Europe", etc.)
4. Click **"Review + create"**
5. Click **"Create"**
6. Wait for deployment to complete (usually 10-30 seconds)

## 🗄️ Step 2: Create Azure Database for MySQL

### 2.1 Create MySQL Server
1. In the Azure Portal, click **"+ Create a resource"**
2. Search for **"Azure Database for MySQL"**
3. Select **"Azure Database for MySQL flexible server"**
4. Click **"Create"**

### 2.2 Configure MySQL Server
#### **Basics Tab:**
- **Subscription**: Your subscription
- **Resource group**: `luxe-hair-studio-rg` (select the one you created)
- **Server name**: `luxe-hair-mysql` (must be globally unique, add numbers if needed)
- **Region**: Same as your resource group
- **MySQL version**: `8.0`
- **Workload type**: `Development` (for cost savings) or `Production` (for better performance)
- **Compute + storage**: Click "Configure server"
  - **Compute tier**: `Burstable` (for development) or `General Purpose` (for production)
  - **Compute size**: `Standard_B1ms` (cheapest option)
  - **Storage size**: `20 GiB` (minimum)
  - **Storage auto-growth**: Enabled
  - Click **"Save"**

#### **Authentication Tab:**
- **Authentication method**: `MySQL authentication only`
- **Admin username**: `luxeadmin`
- **Password**: Create a strong password (e.g., `LuxeHair2024!`)
- **Confirm password**: Re-enter the password

#### **Networking Tab:**
- **Connectivity method**: `Public access (allowed IP addresses)`
- **Firewall rules**: 
  - Check **"Allow public access from any Azure service within Azure to this server"**
  - Add your current IP: Click **"Add current client IP address"**

#### **Security Tab:**
- Leave defaults (encryption enabled)

### 2.3 Create Database
1. Click **"Review + create"**
2. Review settings and click **"Create"**
3. Wait for deployment (5-10 minutes)
4. Once deployed, click **"Go to resource"**
5. In the left sidebar, click **"Databases"**
6. Click **"+ Add"**
7. Database name: `luxe_hair_studio`
8. Click **"Save"**

### 2.4 Note Connection Details
Save these details for later:
- **Server name**: `luxe-hair-mysql.mysql.database.azure.com`
- **Username**: `luxeadmin`
- **Password**: Your chosen password
- **Database**: `luxe_hair_studio`

## 🍃 Step 3: Create Azure Cosmos DB (MongoDB API)

### 3.1 Create Cosmos DB Account
1. Click **"+ Create a resource"**
2. Search for **"Azure Cosmos DB"**
3. Click **"Create"** and select **"Azure Cosmos DB for MongoDB"**

### 3.2 Configure Cosmos DB
#### **Basics Tab:**
- **Subscription**: Your subscription
- **Resource group**: `luxe-hair-studio-rg`
- **Account name**: `luxe-hair-cosmosdb` (must be globally unique)
- **Location**: Same as your resource group
- **Capacity mode**: `Provisioned throughput` (for predictable costs)
- **Apply Free Tier Discount**: `Apply` (if available)
- **Limit total account throughput**: Check this box (helps control costs)

#### **Global Distribution Tab:**
- **Geo-Redundancy**: `Disable` (for cost savings)
- **Multi-region Writes**: `Disable`

#### **Networking Tab:**
- **Connectivity method**: `All networks` (simplest for setup)

#### **Backup Policy Tab:**
- **Backup policy**: `Periodic` (default)

#### **Encryption Tab:**
- Leave defaults

### 3.3 Create Database and Collections
1. Click **"Review + create"**
2. Click **"Create"**
3. Wait for deployment (5-10 minutes)
4. Click **"Go to resource"**
5. In the left sidebar, click **"Data Explorer"**
6. Click **"New Database"**
   - **Database id**: `luxe_hair_studio`
   - **Provision throughput**: Uncheck (we'll set it per collection)
   - Click **"OK"**
7. Click the **three dots** next to your database → **"New Collection"**
   - **Collection id**: `services`
   - **Shard key**: `/category` (for better performance)
   - **Provision dedicated throughput**: Check
   - **Throughput**: `400` (minimum for cost savings)
   - Click **"OK"**
8. Repeat for another collection:
   - **Collection id**: `deals`
   - **Shard key**: `/category`
   - **Throughput**: `400`

### 3.4 Get Connection String
1. In the left sidebar, click **"Connection strings"**
2. Copy the **"Primary Connection String"**
3. Save this for later - it looks like:
   ```
   mongodb://luxe-hair-cosmosdb:PRIMARYKEY@luxe-hair-cosmosdb.mongo.cosmos.azure.com:10255/?ssl=true&replicaSet=globaldb&retrywrites=false&maxIdleTimeMS=120000&appName=@luxe-hair-cosmosdb@
   ```

## 🔄 Step 4: Create Azure Cache for Redis (Optional but Recommended)

### 4.1 Create Redis Cache
1. Click **"+ Create a resource"**
2. Search for **"Azure Cache for Redis"**
3. Click **"Create"**

### 4.2 Configure Redis
#### **Basics Tab:**
- **Subscription**: Your subscription
- **Resource group**: `luxe-hair-studio-rg`
- **DNS name**: `luxe-hair-redis` (must be globally unique)
- **Location**: Same as other resources
- **Cache type**: `Basic C0` (cheapest option for development)

#### **Networking Tab:**
- **Connectivity method**: `Public endpoint`

#### **Advanced Tab:**
- **TLS version**: `1.2` (default)

### 4.3 Complete Creation
1. Click **"Review + create"**
2. Click **"Create"**
3. Wait for deployment (10-15 minutes)
4. Once deployed, go to the resource
5. In the left sidebar, click **"Access keys"**
6. Copy the **"Primary connection string"**

## 🌐 Step 5: Create Azure App Service

### 5.1 Create App Service Plan
1. Click **"+ Create a resource"**
2. Search for **"App Service"**
3. Click **"Create"** → **"Web App"**

### 5.2 Configure Web App
#### **Basics Tab:**
- **Subscription**: Your subscription
- **Resource group**: `luxe-hair-studio-rg`
- **Name**: `luxe-hair-studio-app` (must be globally unique, try variations)
- **Publish**: `Code`
- **Runtime stack**: `PHP 8.2`
- **Operating System**: `Linux`
- **Region**: Same as other resources

#### **App Service Plan:**
- Click **"Create new"**
- **Name**: `luxe-hair-plan`
- **Pricing tier**: 
  - For **development**: `Basic B1` (~$13/month)
  - For **production**: `Standard S1` (~$73/month)
- Click **"OK"**

### 5.3 Advanced Configuration
#### **Deployment Tab:**
- **GitHub Actions settings**: `Enable`
- **GitHub account**: Sign in to your GitHub account
- **Organization**: Your GitHub username
- **Repository**: `hair-salon` (or whatever your repo is named)
- **Branch**: `main`

#### **Monitoring Tab:**
- **Enable Application Insights**: `Yes`
- **Application Insights**: Create new
- **Name**: `luxe-hair-insights`

### 5.4 Create App Service
1. Click **"Review + create"**
2. Click **"Create"**
3. Wait for deployment (5-10 minutes)

## ⚙️ Step 6: Configure App Service Settings

### 6.1 Set Environment Variables
1. Go to your App Service resource
2. In the left sidebar, click **"Configuration"**
3. Click **"+ New application setting"** for each of these:

#### Database Settings:
```
DB_CONNECTION = mysql
DB_HOST = luxe-hair-mysql.mysql.database.azure.com
DB_PORT = 3306
DB_DATABASE = luxe_hair_studio
DB_USERNAME = luxeadmin
DB_PASSWORD = [Your MySQL password]
```

#### MongoDB Settings:
```
DB_MONGO_CONNECTION = mongodb
DB_MONGO_HOST = luxe-hair-cosmosdb.mongo.cosmos.azure.com
DB_MONGO_PORT = 10255
DB_MONGO_DATABASE = luxe_hair_studio
DB_MONGO_USERNAME = luxe-hair-cosmosdb
DB_MONGO_PASSWORD = [Your Cosmos DB primary key]
```

#### Laravel Settings:
```
APP_NAME = Luxe Hair Studio
APP_ENV = production
APP_DEBUG = false
APP_URL = https://luxe-hair-studio-app.azurewebsites.net
APP_KEY = [Generate using: php artisan key:generate --show]
LOG_CHANNEL = single
LOG_LEVEL = info
```

#### Session & Cache Settings (if using Redis):
```
CACHE_DRIVER = redis
SESSION_DRIVER = redis
REDIS_HOST = luxe-hair-redis.redis.cache.windows.net
REDIS_PASSWORD = [Your Redis primary key]
REDIS_PORT = 6380
```

#### Mail Settings (optional):
```
MAIL_MAILER = smtp
MAIL_HOST = smtp.gmail.com
MAIL_PORT = 587
MAIL_USERNAME = your-email@gmail.com
MAIL_PASSWORD = your-app-password
MAIL_ENCRYPTION = tls
MAIL_FROM_ADDRESS = your-email@gmail.com
MAIL_FROM_NAME = Luxe Hair Studio
```

### 6.2 Save Configuration
1. Click **"Save"** at the top
2. Click **"Continue"** when prompted about restart

## 📦 Step 7: Deploy Your Application

### 7.1 Update Your Code Repository
1. In your local project, update `.env.azure` with the actual values from Azure
2. **DO NOT COMMIT** the `.env.azure` file with real credentials
3. Commit and push your prepared code:
   ```bash
   git add .
   git commit -m "Azure deployment configuration"
   git push origin main
   ```

### 7.2 Monitor Deployment
1. In your App Service, go to **"Deployment Center"**
2. You should see GitHub Actions building your app
3. Click on the latest build to see progress
4. Wait for deployment to complete (5-15 minutes)

### 7.3 Run Database Setup
1. In App Service, go to **"Development Tools"** → **"SSH"**
2. Click **"Go"** to open the terminal
3. Run these commands:
   ```bash
   cd /home/site/wwwroot
   php artisan migrate --force
   php artisan db:seed --class=MongoDBSeeder --force
   php artisan storage:link
   php artisan config:cache
   ```

## 📂 Step 8: Set Up File Storage (Optional)

### 8.1 Create Storage Account
1. Click **"+ Create a resource"**
2. Search for **"Storage account"**
3. Click **"Create"**

#### **Basics Tab:**
- **Resource group**: `luxe-hair-studio-rg`
- **Storage account name**: `luxehairstorage` (must be globally unique)
- **Region**: Same as other resources
- **Performance**: `Standard`
- **Redundancy**: `Locally-redundant storage (LRS)`

### 8.2 Create Blob Container
1. Once deployed, go to the storage account
2. In the left sidebar, click **"Containers"**
3. Click **"+ Container"**
4. **Name**: `salon-uploads`
5. **Public access level**: `Blob`
6. Click **"Create"**

### 8.3 Configure App Service for Storage
1. Go back to your App Service → **"Configuration"**
2. Add these application settings:
   ```
   FILESYSTEM_DISK = azure
   AZURE_STORAGE_ACCOUNT_NAME = luxehairstorage
   AZURE_STORAGE_ACCOUNT_KEY = [Get from Storage account → Access keys]
   AZURE_STORAGE_CONTAINER = salon-uploads
   ```

## 🔍 Step 9: Test Your Application

### 9.1 Access Your Application
1. In App Service overview, click the **URL** (e.g., `https://luxe-hair-studio-app.azurewebsites.net`)
2. Your Laravel application should load

### 9.2 Test Key Features
1. **Home Page**: Should load without errors
2. **Login/Register**: Test authentication
3. **Admin Panel**: `https://your-app.azurewebsites.net/admin`
4. **API Endpoints**: `https://your-app.azurewebsites.net/api/services`
5. **Booking System**: Test service booking functionality

### 9.3 Check Logs
If there are issues:
1. Go to App Service → **"Log stream"**
2. Or go to **"Monitoring"** → **"App Service logs"**
3. Enable **"Application logging (File system)"**

## 💰 Step 10: Cost Management

### 10.1 Estimated Monthly Costs (Development)
- **App Service Basic B1**: ~$13
- **MySQL Flexible Server B1ms**: ~$10
- **Cosmos DB (400 RU/s)**: ~$24
- **Redis Basic C0**: ~$15
- **Storage Account**: ~$2
- **Total**: ~$64/month

### 10.2 Cost Optimization Tips
1. **Use Free Tiers**: Apply free tier discounts where available
2. **Scale Down**: Use Basic tiers for development
3. **Monitor Usage**: Set up billing alerts
4. **Auto-shutdown**: Configure App Service to stop during off-hours

### 10.3 Set Up Cost Alerts
1. Go to **"Cost Management + Billing"**
2. Click **"Cost alerts"**
3. Create budget alerts for your resource group

## 🔒 Step 11: Security Best Practices

### 11.1 Configure HTTPS
1. In App Service → **"TLS/SSL settings"**
2. **HTTPS Only**: `On`
3. **Minimum TLS Version**: `1.2`

### 11.2 Database Security
1. **MySQL**: Configure firewall rules to only allow Azure services
2. **Cosmos DB**: Use connection strings with authentication
3. **Redis**: Use access keys and SSL

### 11.3 Application Security
1. **Environment Variables**: Never commit real credentials
2. **Application Insights**: Monitor for security issues
3. **Regular Updates**: Keep Laravel and dependencies updated

## 🔄 Step 12: Backup and Monitoring

### 12.1 Set Up Backups
1. **App Service**: Go to **"Backups"** and configure automatic backups
2. **MySQL**: Automatic backups are enabled by default (7-day retention)
3. **Cosmos DB**: Automatic backups with 30-day retention

### 12.2 Set Up Monitoring
1. **Application Insights**: Already configured during App Service creation
2. **Alerts**: Set up alerts for errors, performance issues
3. **Availability Tests**: Set up URL ping tests

## 🎉 Deployment Complete!

Your Luxe Hair Studio application is now running on Azure! 

### Access URLs:
- **Application**: `https://your-app-name.azurewebsites.net`
- **Admin Panel**: `https://your-app-name.azurewebsites.net/admin`
- **API**: `https://your-app-name.azurewebsites.net/api/services`

### Next Steps:
1. **Custom Domain**: Add your own domain name
2. **SSL Certificate**: Upload custom SSL certificate
3. **CDN**: Set up Azure CDN for better performance
4. **Scaling**: Configure auto-scaling based on demand

## 📞 Support and Troubleshooting

### Common Issues:
1. **500 Errors**: Check Application Insights logs
2. **Database Connection**: Verify connection strings
3. **Missing Assets**: Ensure `npm run build` completed
4. **MongoDB Issues**: Check Cosmos DB firewall settings

### Azure Support:
- **Documentation**: [Azure App Service Docs](https://docs.microsoft.com/azure/app-service/)
- **Community**: [Azure Forums](https://docs.microsoft.com/answers/topics/azure.html)
- **Support**: Azure Support Plans for technical help

---

**Congratulations!** 🎊 You've successfully deployed your Laravel salon application to Azure using only the Azure Portal GUI!