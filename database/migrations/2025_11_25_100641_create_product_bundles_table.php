<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_bundles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->string('image_url')->nullable();
            $table->decimal('price', 10, 2); // Bundle price
            $table->decimal('compare_price', 10, 2)->nullable(); // Sum of individual prices
            $table->integer('discount_percentage')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('stock_quantity')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('is_active');
        });

        Schema::create('bundle_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundle_id')->constrained('product_bundles')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->unique(['bundle_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bundle_products');
        Schema::dropIfExists('product_bundles');
    }
};
