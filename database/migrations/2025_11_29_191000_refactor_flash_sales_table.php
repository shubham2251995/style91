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
        Schema::table('flash_sales', function (Blueprint $table) {
            // Drop single product columns
            $table->dropColumn(['product_id', 'discount_percentage']);
            
            // Add campaign columns
            $table->string('name')->after('id');
            $table->string('slug')->unique()->after('name');
            $table->string('banner_image')->nullable()->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('flash_sales', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable(); // Made nullable to avoid rollback errors
            $table->integer('discount_percentage')->nullable();
            
            $table->dropColumn(['name', 'slug', 'banner_image']);
        });
    }
};
