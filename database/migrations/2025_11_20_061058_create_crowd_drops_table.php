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
        Schema::create('crowd_drops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->decimal('start_price', 10, 2);
            $table->decimal('current_price', 10, 2);
            $table->decimal('min_price', 10, 2); // Floor price
            $table->decimal('drop_amount', 8, 2); // Amount to drop per person
            $table->integer('participants_count')->default(0);
            $table->timestamp('expires_at');
            $table->string('status')->default('active'); // active, completed, expired
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crowd_drops');
    }
};
