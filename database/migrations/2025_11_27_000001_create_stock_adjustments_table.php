<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->comment('Admin who made the adjustment');
            $table->integer('quantity_change')->comment('Positive for increase, negative for decrease');
            $table->integer('old_quantity');
            $table->integer('new_quantity');
            $table->enum('reason', ['damaged', 'returned', 'lost', 'found', 'manual', 'correction', 'supplier']);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['product_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_adjustments');
    }
};
