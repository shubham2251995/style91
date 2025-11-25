<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Initiate, Insider, Icon
            $table->decimal('threshold', 10, 2); // Spend required to unlock
            $table->decimal('discount_percentage', 5, 2)->default(0); // Discount on all orders
            $table->string('color')->default('#000000'); // Hex code for badge
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_tiers');
    }
};
