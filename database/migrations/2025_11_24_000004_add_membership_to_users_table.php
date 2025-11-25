<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('lifetime_spend', 12, 2)->default(0.00)->after('role');
            $table->foreignId('membership_tier_id')->nullable()->after('lifetime_spend')->constrained('membership_tiers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['membership_tier_id']);
            $table->dropColumn(['lifetime_spend', 'membership_tier_id']);
        });
    }
};
