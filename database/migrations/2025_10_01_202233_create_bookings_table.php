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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Customer Information
            $table->unsignedBigInteger('customer_id')->nullable(); // For registered users
            $table->string('customer_first_name');
            $table->string('customer_last_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            
            // Service Information
            $table->string('service_id'); // MongoDB ObjectId as string
            $table->string('service_name');
            $table->decimal('service_price', 8, 2);
            
            // Booking Details
            $table->date('booking_date');
            $table->time('booking_time');
            $table->integer('duration_minutes')->default(60);
            $table->decimal('total_price', 8, 2);
            $table->text('special_requests')->nullable();
            
            // Status Management
            $table->enum('status', ['pending', 'confirmed', 'in-progress', 'completed', 'cancelled'])
                  ->default('pending');
            $table->text('admin_notes')->nullable();
            
            // Staff Assignment (optional)
            $table->unsignedBigInteger('staff_id')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['booking_date', 'booking_time']);
            $table->index('status');
            $table->index('customer_email');
            $table->index('service_id');
            
            // Foreign key constraints
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
