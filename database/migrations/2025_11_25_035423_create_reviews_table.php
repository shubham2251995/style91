<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->tinyInteger('rating')->unsigned(); // 1-5
            $table->text('comment')->nullable();
            $table->boolean('verified_purchase')->default(false);
            $table->boolean('is_approved')->default(true); // Set to false for moderation
            $table->timestamps();

            $table->index('product_id');
            $table->index('is_approved');
            $table->unique(['user_id', 'product_id']); // One review per product per user
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
