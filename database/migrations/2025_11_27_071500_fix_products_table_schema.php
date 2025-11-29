<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check and rename stock to stock_quantity
        if (Schema::hasColumn('products', 'stock') && !Schema::hasColumn('products', 'stock_quantity')) {
            Schema::table('products', function (Blueprint $table) {
                $table->renameColumn('stock', 'stock_quantity');
            });
        }
        
        // Check and drop category column
        if (Schema::hasColumn('products', 'category')) {
            Schema::table('products', function (Blueprint $table) {
                // Explicitly drop index first to prevent SQLite errors
                try {
                    $table->dropIndex(['category']);
                } catch (\Exception $e) {
                    // Index might not exist or already dropped
                }
                $table->dropColumn('category');
            });
        }
        
        // Ensure category_id exists
        if (!Schema::hasColumn('products', 'category_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('category_id')->nullable()->after('image_url')->constrained()->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        // Reverse the changes
        if (Schema::hasColumn('products', 'stock_quantity') && !Schema::hasColumn('products', 'stock')) {
            DB::statement('ALTER TABLE products RENAME COLUMN stock_quantity TO stock');
        }
        
        if (!Schema::hasColumn('products', 'category')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('category')->nullable()->index();
            });
        }
        
        if (Schema::hasColumn('products', 'category_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            });
        }
    }
};
