<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('countries')->nullable(); // Array of country codes
            $table->json('states')->nullable(); // Array of state codes
            $table->json('postcodes')->nullable(); // Array of postal codes or ranges
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Pivot table for shipping zones and methods with zone-specific pricing
        Schema::create('shipping_zone_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_zone_id')->constrained()->cascadeOnDelete();
            $table->foreignId('shipping_method_id')->constrained()->cascadeOnDelete();
            $table->decimal('cost_override', 10, 2)->nullable(); // Zone-specific cost
            $table->boolean('is_enabled')->default(true);
            $table->timestamps();

            $table->unique(['shipping_zone_id', 'shipping_method_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_zone_methods');
        Schema::dropIfExists('shipping_zones');
    }
};
