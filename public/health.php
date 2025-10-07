<?php
/**
 * Health Check & Diagnostic Endpoint
 * Access via: https://your-app.railway.app/health.php
 */

header('Content-Type: text/plain');
echo "=== RAILWAY HEALTH CHECK ===\n\n";

// 1. PHP Version
echo "PHP Version: " . PHP_VERSION . "\n";

// 2. Check if vendor exists
echo "Vendor folder exists: " . (is_dir(__DIR__.'/../vendor') ? 'YES' : 'NO') . "\n";

// 3. Try to load Laravel
try {
    require __DIR__.'/../vendor/autoload.php';
    echo "Autoload: SUCCESS\n";
    
    $app = require_once __DIR__.'/../bootstrap/app.php';
    echo "Laravel Bootstrap: SUCCESS\n";
    
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo "Kernel Bootstrap: SUCCESS\n";
    
} catch (\Exception $e) {
    echo "Laravel Bootstrap: FAILED\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    exit(1);
}

// 4. Environment
echo "\nEnvironment: " . config('app.env') . "\n";
echo "Debug: " . (config('app.debug') ? 'ON' : 'OFF') . "\n";

// 5. Database Connections
echo "\n=== DATABASE CONNECTIONS ===\n";

// SQLite
try {
    $sqliteDb = config('database.connections.sqlite.database');
    echo "SQLite DB: " . $sqliteDb . "\n";
    echo "SQLite exists: " . (file_exists($sqliteDb) ? 'YES' : 'NO') . "\n";
    
    \Illuminate\Support\Facades\DB::connection('sqlite')->getPdo();
    echo "SQLite connection: SUCCESS\n";
} catch (\Exception $e) {
    echo "SQLite connection: FAILED - " . $e->getMessage() . "\n";
}

// MongoDB
echo "\n";
try {
    $mongoConfig = config('database.connections.mongodb');
    echo "MongoDB Host: " . $mongoConfig['host'] . "\n";
    echo "MongoDB Port: " . $mongoConfig['port'] . "\n";
    echo "MongoDB Database: " . $mongoConfig['database'] . "\n";
    echo "MongoDB Username: " . ($mongoConfig['username'] ? '***SET***' : 'NOT SET') . "\n";
    echo "MongoDB Password: " . ($mongoConfig['password'] ? '***SET***' : 'NOT SET') . "\n";
    
    $mongo = \Illuminate\Support\Facades\DB::connection('mongodb')->getMongoClient();
    $databases = iterator_to_array($mongo->listDatabases());
    echo "MongoDB connection: SUCCESS\n";
    echo "Available databases: " . count($databases) . "\n";
    
    // Check collections
    $db = \Illuminate\Support\Facades\DB::connection('mongodb')->getMongoDB();
    $collections = iterator_to_array($db->listCollections());
    echo "Collections in " . $mongoConfig['database'] . ": " . count($collections) . "\n";
    
    if (count($collections) > 0) {
        foreach ($collections as $collection) {
            $name = $collection->getName();
            $count = $db->selectCollection($name)->countDocuments();
            echo "  - $name: $count documents\n";
        }
    } else {
        echo "  (no collections found - database is empty)\n";
    }
    
} catch (\Exception $e) {
    echo "MongoDB connection: FAILED\n";
    echo "Error: " . $e->getMessage() . "\n";
}

// 6. Import files
echo "\n=== IMPORT FILES ===\n";
$servicesFile = __DIR__.'/../mongodb_services_export.json';
$dealsFile = __DIR__.'/../mongodb_deals_export.json';
echo "Services export exists: " . (file_exists($servicesFile) ? 'YES' : 'NO') . "\n";
echo "Deals export exists: " . (file_exists($dealsFile) ? 'YES' : 'NO') . "\n";

if (file_exists($servicesFile)) {
    $servicesData = json_decode(file_get_contents($servicesFile), true);
    echo "Services in file: " . count($servicesData) . "\n";
}

if (file_exists($dealsFile)) {
    $dealsData = json_decode(file_get_contents($dealsFile), true);
    echo "Deals in file: " . count($dealsData) . "\n";
}

echo "\n=== END HEALTH CHECK ===\n";
