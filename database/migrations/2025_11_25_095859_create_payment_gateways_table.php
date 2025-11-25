<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Razorpay, Cashfree, COD
            $table->string('code')->unique(); // razorpay, cashfree, cod
            $table->text('description')->nullable();
            $table->json('config')->nullable(); // API keys, secrets, etc.
            $table->json('rules')->nullable(); // Payment rules
            $table->boolean('is_active')->default(false);
            $table->boolean('is_test_mode')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
