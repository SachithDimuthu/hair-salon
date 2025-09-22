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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('employee_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->date('hire_date');
            $table->enum('position', ['stylist', 'colorist', 'manager', 'receptionist', 'assistant']);
            $table->json('specializations')->nullable();
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->decimal('commission_rate', 5, 2)->nullable(); // percentage
            $table->boolean('is_active')->default(true);
            $table->text('bio')->nullable();
            $table->string('profile_image')->nullable();
            $table->timestamps();

            $table->index(['employee_id']);
            $table->index(['email']);
            $table->index(['position']);
            $table->index(['is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
