<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;

class NormalizeServiceDocuments extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'services:normalize
                           {--dry-run : Show what would be changed without making changes}';

    /**
     * The console command description.
     */
    protected $description = 'Normalize Service documents by converting JSON strings to arrays/objects';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        if ($dryRun) {
            $this->info('Running in DRY RUN mode - no changes will be made');
        }

        $this->info('Starting Service document normalization...');

        try {
            // Get all services using raw MongoDB collection
            $collection = Service::getCollection();
            $services = $collection->find();
            
            $updatedCount = 0;
            $totalCount = 0;

            foreach ($services as $service) {
                $totalCount++;
                $updates = [];
                $needsUpdate = false;

                // Check and convert durations if it's a JSON string
                if (isset($service['durations']) && is_string($service['durations'])) {
                    $decoded = json_decode($service['durations'], true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $updates['durations'] = $decoded;
                        $needsUpdate = true;
                        $this->line("- Service '{$service['name']}': Converting durations from JSON string to array");
                    }
                }

                // Check and convert tags if it's a JSON string
                if (isset($service['tags']) && is_string($service['tags'])) {
                    $decoded = json_decode($service['tags'], true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $updates['tags'] = $decoded;
                        $needsUpdate = true;
                        $this->line("- Service '{$service['name']}': Converting tags from JSON string to array");
                    }
                }

                // Check and convert staff_ids if it's a JSON string
                if (isset($service['staff_ids']) && is_string($service['staff_ids'])) {
                    $decoded = json_decode($service['staff_ids'], true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $updates['staff_ids'] = $decoded;
                        $needsUpdate = true;
                        $this->line("- Service '{$service['name']}': Converting staff_ids from JSON string to array");
                    }
                }

                // Check and convert addon_ids if it's a JSON string
                if (isset($service['addon_ids']) && is_string($service['addon_ids'])) {
                    $decoded = json_decode($service['addon_ids'], true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $updates['addon_ids'] = $decoded;
                        $needsUpdate = true;
                        $this->line("- Service '{$service['name']}': Converting addon_ids from JSON string to array");
                    }
                }

                // Check and convert booking_constraints if it's a JSON string
                if (isset($service['booking_constraints']) && is_string($service['booking_constraints'])) {
                    $decoded = json_decode($service['booking_constraints'], true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $updates['booking_constraints'] = $decoded;
                        $needsUpdate = true;
                        $this->line("- Service '{$service['name']}': Converting booking_constraints from JSON string to object");
                    }
                }

                // Convert Decimal128 to float for base_price if needed
                if (isset($service['base_price']) && is_object($service['base_price']) && 
                    get_class($service['base_price']) === 'MongoDB\BSON\Decimal128') {
                    $updates['base_price'] = (float) $service['base_price']->toString();
                    $needsUpdate = true;
                    $this->line("- Service '{$service['name']}': Converting base_price from Decimal128 to float");
                }

                // Apply updates if needed
                if ($needsUpdate && !$dryRun) {
                    $collection->updateOne(
                        ['_id' => $service['_id']],
                        ['$set' => $updates]
                    );
                    $updatedCount++;
                }
            }

            if ($dryRun) {
                $this->info("DRY RUN completed. Found {$totalCount} total services.");
                $this->info("Would normalize data structure for services that need updates.");
            } else {
                $this->info("Normalization completed successfully!");
                $this->info("Updated {$updatedCount} out of {$totalCount} services.");
            }

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Error during normalization: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}