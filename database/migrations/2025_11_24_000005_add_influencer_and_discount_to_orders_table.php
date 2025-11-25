<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('influencer_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            $table->decimal('discount_amount', 10, 2)->default(0.00)->after('total');
            // We might want to rename 'total' to 'subtotal' or just keep 'total' as the final amount paid.
            // Let's assume 'total' is the final amount paid.
            // So: Subtotal - Discount = Total.
            // But for now, let's just add discount_amount for tracking.
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['influencer_id']);
            $table->dropColumn(['influencer_id', 'discount_amount']);
        });
    }
};
