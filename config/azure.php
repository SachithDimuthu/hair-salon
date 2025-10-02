<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Azure Blob Storage Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Azure Blob Storage integration with Laravel.
    | This file should be updated with your actual Azure Storage credentials
    | when deploying to Azure.
    |
    */

    'azure' => [
        'driver' => 'azure',
        'account' => env('AZURE_STORAGE_ACCOUNT_NAME'),
        'key' => env('AZURE_STORAGE_ACCOUNT_KEY'),
        'container' => env('AZURE_STORAGE_CONTAINER', 'salon-uploads'),
        'url' => env('AZURE_STORAGE_URL'),
        'prefix' => env('AZURE_STORAGE_PREFIX', ''),
    ],
];