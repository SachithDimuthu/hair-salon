#!/bin/bash

# Test Railway Deployment After Fix

echo "================================"
echo "Testing Railway Deployment"
echo "================================"
echo ""

echo "1. Testing basic API endpoint..."
curl -s https://hair-salon-production.up.railway.app/api | jq .
echo ""

echo "2. Testing debug endpoint..."
curl -s https://hair-salon-production.up.railway.app/api/debug/auth-status | jq .
echo ""

echo "3. Testing registration endpoint..."
curl -s -X POST https://hair-salon-production.up.railway.app/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }' | jq .

echo ""
echo "================================"
echo "Tests Complete"
echo "================================"
