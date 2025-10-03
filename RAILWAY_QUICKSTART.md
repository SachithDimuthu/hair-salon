# Railway Quick Start Guide

## 🚀 Quick Deployment Steps

### 1. Prerequisites
- Railway account: [railway.app](https://railway.app)
- GitHub repository with your code

### 2. Deploy to Railway

#### Option A: One-Click Deploy
1. Push your code to GitHub
2. Go to [railway.app](https://railway.app)
3. Click "Deploy from GitHub repo"
4. Select your repository

#### Option B: Railway CLI
```bash
# Install Railway CLI
npm install -g @railway/cli

# Login and deploy
railway login
railway link
railway up
```

### 3. Add Services
After deploying your app, add these services to your Railway project:

1. **PostgreSQL Database**
   - Click "New Service" → "PostgreSQL"
   - Railway will auto-connect with environment variables

2. **MongoDB Database**  
   - Click "New Service" → "MongoDB"
   - Note: Railway provides MongoDB community templates

3. **Redis Cache** (Optional)
   - Click "New Service" → "Redis"

### 4. Environment Variables
Copy from `.env.railway` and add to Railway:

**Required Variables:**
```
APP_KEY=base64:YOUR_KEY_HERE
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app
```

**Database Variables** (Auto-provided by Railway):
- `PGHOST`, `PGDATABASE`, `PGUSER`, `PGPASSWORD`
- `MONGO_URL`
- `REDIS_URL`

### 5. Post-Deployment
Run these commands via Railway CLI:
```bash
railway run php artisan migrate --force
railway run php artisan storage:link
railway run php artisan optimize
```

### 6. Custom Domain (Optional)
1. Go to Settings → Domains
2. Add your custom domain
3. Update DNS records

## 🎉 That's it!
Your hair salon app should now be live with PostgreSQL + MongoDB!

**Need help?** Check the full `RAILWAY_DEPLOYMENT_GUIDE.md` for detailed instructions.