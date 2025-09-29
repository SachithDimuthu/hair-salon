<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('CustomerID')->constrained('customers', 'CustomerID')->onDelete('cascade');
            $table->foreignId('ServiceID')->constrained('services', 'ServiceID')->onDelete('cascade');
            $table->timestamp('BookedAt')->useCurrent();
            $table->enum('Status', ['booked', 'completed', 'cancelled'])->default('booked');
            $table->timestamps();
            
            $table->unique(['CustomerID', 'ServiceID', 'BookedAt']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_service');
    }
};
