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
        Schema::table('products', function (Blueprint $table) {
            // Enhanced fields for product card display
            $table->string('badge')->nullable()->after('slug'); // new, trending, bestseller, exclusive
            $table->integer('sold_count')->default(0)->after('stock_quantity');
            $table->integer('view_count')->default(0)->after('sold_count');
            $table->decimal('avg_rating', 3, 2)->default(0)->after('view_count'); // 0.00 to 5.00
            $table->integer('review_count')->default(0)->after('avg_rating');
            $table->boolean('is_featured')->default(false)->after('review_count');
            
            // SEO fields
            $table->string('meta_title')->nullable()->after('description');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
            
            // Size guide (JSON)
            $table->json('size_guide')->nullable()->after('meta_keywords');
            
            // Add indexes for performance
            $table->index('badge');
            $table->index('is_featured');
            $table->index('avg_rating');
            $table->index('sold_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['badge']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['avg_rating']);
            $table->dropIndex(['sold_count']);
            
            $table->dropColumn([
                'badge',
                'sold_count',
                'view_count',
                'avg_rating',
                'review_count',
                'is_featured',
                'meta_title',
                'meta_description',
                'meta_keywords',
                'size_guide',
            ]);
        });
    }
};
