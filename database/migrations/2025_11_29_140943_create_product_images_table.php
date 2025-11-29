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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('path'); // Storage path
            $table->string('url'); // Public URL
            $table->string('thumbnail_url')->nullable(); // Thumbnail URL
            $table->integer('display_order')->default(0); // For sorting
            $table->boolean('is_primary')->default(false); // Primary image flag
            $table->string('alt_text')->nullable(); // SEO alt text
            $table->timestamps();
            
            // Indexes
            $table->index('product_id');
            $table->index(['product_id', 'is_primary']);
            $table->index(['product_id', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
