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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('item_type', ['product', 'service']);
            $table->string('name'); // snapshot of item name at time of order
            $table->decimal('price', 8, 2); // snapshot of price at time of order
            $table->integer('quantity')->default(1);
            $table->decimal('total', 8, 2); // price * quantity
            $table->timestamps();

            $table->index(['order_id']);
            $table->index(['product_id']);
            $table->index(['service_id']);
            $table->index(['item_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
