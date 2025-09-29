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
        Schema::create('deals', function (Blueprint $table) {
            $table->id('DealID'); // As per ERD
            $table->string('DealName');
            $table->text('Description')->nullable();
            $table->decimal('DiscountPercentage', 5, 2);
            $table->date('StartDate');
            $table->date('EndDate');
            $table->boolean('IsActive')->default(true);
            $table->foreignId('ServiceID')->nullable()->constrained('services', 'ServiceID')->onDelete('cascade'); // 1:1 relationship
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
