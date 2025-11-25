<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('size_guides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('name'); // e.g., "Men's T-Shirts", "Women's Jeans"
            $table->text('description')->nullable();
            $table->json('measurements'); // Size chart data
            $table->json('fit_recommendations')->nullable(); // Fit finder logic
            $table->string('measurement_unit')->default('cm'); // cm or inches
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('category_id');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('size_guides');
    }
};
