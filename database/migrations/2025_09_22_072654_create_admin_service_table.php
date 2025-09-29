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
        Schema::create('admin_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('AdminID')->constrained('admins', 'AdminID')->onDelete('cascade');
            $table->foreignId('ServiceID')->constrained('services', 'ServiceID')->onDelete('cascade');
            $table->timestamp('ManagedSince')->useCurrent();
            $table->timestamps();
            
            $table->unique(['AdminID', 'ServiceID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_service');
    }
};
