<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['flat_rate', 'free_shipping', 'local_pickup']);
            $table->decimal('cost', 10, 2)->default(0);
            $table->decimal('min_order_amount', 10, 2)->nullable(); // For free shipping threshold
            $table->integer('estimated_days_min')->default(3);
            $table->integer('estimated_days_max')->default(7);
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_methods');
    }
};
