<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use App\Models\Deal;

class ImportMongoDataCommand extends Command
{
    protected $signature = 'mongodb:import {--services} {--deals}';
    protected $description = 'Import MongoDB data from JSON files';

    public function handle()
    {
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

        $json = file_get_contents($file);
        $services = json_decode($json, true);

        if (!$services) {
            $this->error('Invalid JSON in services file');
            return;
        }

        $this->info('Truncating existing services...');
        Service::truncate();

        $bar = $this->output->createProgressBar(count($services));
        $bar->start();

        foreach ($services as $service) {
            Service::create($service);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('✅ Imported ' . count($services) . ' services');
    }

    private function importDeals()
    {
        $this->info('Importing deals...');
        
        $file = base_path('mongodb_deals_export.json');
        if (!file_exists($file)) {
            $this->error("File not found: $file");
            return;
        }

        $json = file_get_contents($file);
        $deals = json_decode($json, true);

        if (!$deals) {
            $this->error('Invalid JSON in deals file');
            return;
        }

        $this->info('Truncating existing deals...');
        Deal::truncate();

        $bar = $this->output->createProgressBar(count($deals));
        $bar->start();

        foreach ($deals as $deal) {
            Deal::create($deal);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('✅ Imported ' . count($deals) . ' deals');
    }
}
