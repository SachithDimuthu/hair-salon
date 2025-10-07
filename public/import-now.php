<?php
/**
 * Emergency MongoDB Import Endpoint
 * Access via: https://your-app.railway.app/import-now.php?key=luxe2024
 * DELETE THIS FILE AFTER SUCCESSFUL IMPORT!
 */

// Security key
if (!isset($_GET['key']) || $_GET['key'] !== 'luxe2024') {
    http_response_code(403);
    die('Access denied');
}

// Bootstrap Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/plain');
echo "🔌 Starting MongoDB Import...\n";
flush();

try {
    // Test connection
    echo "Testing MongoDB connection...\n";
    flush();
    
    $mongo = \Illuminate\Support\Facades\DB::connection('mongodb')->getMongoClient();
    $mongo->listDatabases();
    echo "✅ MongoDB connected!\n\n";
    flush();
    
    // Import services
    echo "📦 Importing Services...\n";
    flush();
    
    $servicesFile = __DIR__.'/../mongodb_services_export.json';
    if (!file_exists($servicesFile)) {
        throw new Exception("Services file not found: $servicesFile");
    }
    
    $servicesJson = file_get_contents($servicesFile);
    $services = json_decode($servicesJson, true, 512, JSON_THROW_ON_ERROR);
    
    App\Models\Service::truncate();
    
    $serviceCount = 0;
    foreach ($services as $service) {
        // Normalize MongoDB extended JSON
        if (isset($service['id'])) {
            $service['_id'] = is_array($service['id']) && isset($service['id']['$oid'])
                ? $service['id']['$oid']
                : $service['id'];
            unset($service['id']);
        }
        
        // Convert $numberDecimal
        foreach ($service as $key => $value) {
            if (is_array($value) && isset($value['$numberDecimal'])) {
                $service[$key] = (float)$value['$numberDecimal'];
            }
        }
        
        App\Models\Service::create($service);
        $serviceCount++;
        echo ".";
        if ($serviceCount % 5 == 0) {
            flush();
        }
    }
    
    echo "\n✅ Imported $serviceCount services\n\n";
    flush();
    
    // Import deals
    echo "🎁 Importing Deals...\n";
    flush();
    
    $dealsFile = __DIR__.'/../mongodb_deals_export.json';
    if (!file_exists($dealsFile)) {
        throw new Exception("Deals file not found: $dealsFile");
    }
    
    $dealsJson = file_get_contents($dealsFile);
    $deals = json_decode($dealsJson, true, 512, JSON_THROW_ON_ERROR);
    
    App\Models\Deal::truncate();
    
    $dealCount = 0;
    foreach ($deals as $deal) {
        // Normalize MongoDB extended JSON
        if (isset($deal['id'])) {
            $deal['_id'] = is_array($deal['id']) && isset($deal['id']['$oid'])
                ? $deal['id']['$oid']
                : $deal['id'];
            unset($deal['id']);
        }
        
        // Convert $numberDecimal
        foreach ($deal as $key => $value) {
            if (is_array($value) && isset($value['$numberDecimal'])) {
                $deal[$key] = (float)$value['$numberDecimal'];
            }
        }
        
        App\Models\Deal::create($deal);
        $dealCount++;
        echo ".";
        if ($dealCount % 5 == 0) {
            flush();
        }
    }
    
    echo "\n✅ Imported $dealCount deals\n\n";
    flush();
    
    echo "=" . str_repeat("=", 50) . "\n";
    echo "🎉 SUCCESS! MongoDB Import Complete!\n";
    echo "=" . str_repeat("=", 50) . "\n";
    echo "Services: $serviceCount\n";
    echo "Deals: $dealCount\n";
    echo "\n⚠️ IMPORTANT: Delete this file (import-now.php) immediately!\n";
    
} catch (Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "\nStack Trace:\n" . $e->getTraceAsString() . "\n";
}
