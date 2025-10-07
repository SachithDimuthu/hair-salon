<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use App\Models\Deal;
use Illuminate\Support\Facades\DB;

class ImportMongoDataCommand extends Command
{
    protected $signature = 'mongodb:import {--services} {--deals}';
    protected $description = 'Import MongoDB data from JSON files';

    public function handle()
    {
        $this->info('🔌 Testing MongoDB connection...');
        
        // Test connection with retry logic
        $maxRetries = 3;
        $connected = false;
        
        for ($i = 1; $i <= $maxRetries; $i++) {
            try {
                DB::connection('mongodb')->getMongoClient()->listDatabases();
                $this->info("✅ MongoDB connected successfully");
                $connected = true;
                break;
            } catch (\Exception $e) {
                $this->warn("Connection attempt $i/$maxRetries failed: " . $e->getMessage());
                if ($i < $maxRetries) {
                    $this->info("Retrying in 2 seconds...");
                    sleep(2);
                }
            }
        }
        
        if (!$connected) {
            $this->error('❌ Could not connect to MongoDB after ' . $maxRetries . ' attempts');
            return 1;
        }

        if ($this->option('services')) {
            $this->importServices();
        } elseif ($this->option('deals')) {
            $this->importDeals();
        } else {
            $this->importServices();
            $this->importDeals();
        }

        return 0;
    }

    private function importServices()
    {
        $this->info('Importing services...');
        
        $file = base_path('mongodb_services_export.json');
        if (!file_exists($file)) {
            $this->error("File not found: $file");
            return;
        }

        try {
            $json = file_get_contents($file);
            $services = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $this->error('Invalid JSON in services file: ' . $e->getMessage());
            return;
        }

        try {
            $this->info('Truncating existing services...');
            Service::truncate();

            $bar = $this->output->createProgressBar(count($services));
            $bar->start();

            foreach ($services as $service) {
                $service = $this->normalizeDocument($service);
                Service::create($service);
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info('✅ Imported ' . count($services) . ' services');
        } catch (\Exception $e) {
            $this->newLine();
            $this->error('❌ Error importing services: ' . $e->getMessage());
            $this->error('Trace: ' . $e->getTraceAsString());
        }
    }

    private function importDeals()
    {
        $this->info('Importing deals...');
        
        $file = base_path('mongodb_deals_export.json');
        if (!file_exists($file)) {
            $this->error("File not found: $file");
            return;
        }

        try {
            $json = file_get_contents($file);
            $deals = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $this->error('Invalid JSON in deals file: ' . $e->getMessage());
            return;
        }

        try {
            $this->info('Truncating existing deals...');
            Deal::truncate();

            $bar = $this->output->createProgressBar(count($deals));
            $bar->start();

            foreach ($deals as $deal) {
                $deal = $this->normalizeDocument($deal);
                Deal::create($deal);
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info('✅ Imported ' . count($deals) . ' deals');
        } catch (\Exception $e) {
            $this->newLine();
            $this->error('❌ Error importing deals: ' . $e->getMessage());
            $this->error('Trace: ' . $e->getTraceAsString());
        }
    }

    private function normalizeDocument(array $document): array
    {
        if (isset($document['id'])) {
            $document['_id'] = is_array($document['id']) && isset($document['id']['$oid'])
                ? $document['id']['$oid']
                : $document['id'];
            unset($document['id']);
        }

        foreach ($document as $key => $value) {
            if (is_array($value)) {
                if (array_key_exists('$numberDecimal', $value)) {
                    $document[$key] = (float)$value['$numberDecimal'];
                } elseif (array_key_exists('$oid', $value)) {
                    $document[$key] = $value['$oid'];
                } else {
                    $document[$key] = $this->normalizeDocument($value);
                }
            }
        }

        return $document;
    }
}
