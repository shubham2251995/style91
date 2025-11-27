<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create table if it doesn't exist
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained();
                $table->string('guest_email')->nullable();
                $table->string('status')->default('pending');
                $table->decimal('total', 10, 2);
                $table->json('shipping_address');
                $table->string('payment_method');
                $table->timestamps();
            });
        }

        // 2. Add new columns
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'shipping_cost')) {
                $table->decimal('shipping_cost', 10, 2)->default(0)->after('shipping_phone'); // Note: shipping_phone might not exist if table was just created above
            }
            if (!Schema::hasColumn('orders', 'shipping_method')) {
                $table->string('shipping_method')->nullable()->after('shipping_cost');
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'payment_id')) {
                $table->string('payment_id')->nullable()->after('payment_status');
            }
            
            // Also ensure shipping_phone exists (it was in the fillable but maybe not in original schema?)
            // Checking original schema: it did NOT have shipping_phone.
            if (!Schema::hasColumn('orders', 'shipping_phone')) {
                $table->string('shipping_phone')->nullable()->after('shipping_address');
            }
            
            // Ensure other fields from Order model fillable are present
             if (!Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->nullable()->after('total'); // Redundant with total?
            }
             if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->decimal('discount_amount', 10, 2)->default(0)->after('total_amount');
            }
             if (!Schema::hasColumn('orders', 'coupon_code')) {
                $table->string('coupon_code')->nullable()->after('discount_amount');
            }
             if (!Schema::hasColumn('orders', 'influencer_id')) {
                $table->foreignId('influencer_id')->nullable()->after('coupon_code');
            }
             if (!Schema::hasColumn('orders', 'tracking_number')) {
                $table->string('tracking_number')->nullable()->after('payment_id');
            }
             if (!Schema::hasColumn('orders', 'shipped_at')) {
                $table->timestamp('shipped_at')->nullable()->after('tracking_number');
            }
             if (!Schema::hasColumn('orders', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            }
        });
    }

    public function down(): void
    {
        // 
    }
};
