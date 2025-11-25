<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlist_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->enum('alert_type', ['price_drop', 'back_in_stock']);
            $table->decimal('threshold_price', 10, 2)->nullable(); // For price drop alerts
            $table->boolean('is_sent')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'product_id', 'alert_type']);
            $table->index('is_sent');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlist_alerts');
    }
};
