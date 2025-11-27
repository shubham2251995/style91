<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            if (!Schema::hasColumn('coupons', 'used_count')) {
                $table->integer('used_count')->default(0)->after('usage_limit');
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            // Ensure discount_amount exists first
            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->decimal('discount_amount', 10, 2)->default(0)->after('total');
            }
            
            if (!Schema::hasColumn('orders', 'coupon_discount')) {
                $table->decimal('coupon_discount', 10, 2)->default(0)->after('discount_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('used_count');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('coupon_discount');
        });
    }
};
