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
        Schema::create('admin_customer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('AdminID')->constrained('admins', 'AdminID')->onDelete('cascade');
            $table->foreignId('CustomerID')->constrained('customers', 'CustomerID')->onDelete('cascade');
            $table->timestamp('ManagedSince')->useCurrent();
            $table->timestamps();
            
            $table->unique(['AdminID', 'CustomerID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_customer');
    }
};
