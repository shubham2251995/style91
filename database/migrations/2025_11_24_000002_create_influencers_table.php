<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('influencers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('code')->unique(); // e.g. JONNY10
            $table->decimal('commission_rate', 5, 2)->default(10.00); // Percentage
            $table->decimal('earnings', 10, 2)->default(0.00);
            $table->string('status')->default('pending'); // pending, active, rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('influencers');
    }
};
