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
        Schema::create('homepage_sections', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // hero, categories, featured_products, banner, etc.
            $table->string('title')->nullable();
            $table->json('content'); // Section-specific configuration
            $table->integer('order')->default(0); // Display order
            $table->boolean('is_active')->default(true); // Visibility toggle
            $table->json('rules')->nullable(); // Visibility rules
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_sections');
    }
};
