#!/bin/bash

echo "🔍 Checking MongoDB status..."

# Check if services collection exists and has data
SERVICE_COUNT=$(php artisan tinker --execute="echo App\Models\Service::count();" 2>/dev/null | tail -1)

if [ -z "$SERVICE_COUNT" ] || [ "$SERVICE_COUNT" -eq 0 ]; then
    echo "📦 MongoDB is empty. Running import..."
    php artisan mongodb:import
    echo "✅ Import completed"
else
    echo "✅ MongoDB already has $SERVICE_COUNT services. Skipping import."
fi
