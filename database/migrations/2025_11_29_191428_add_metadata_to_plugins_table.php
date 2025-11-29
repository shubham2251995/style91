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
        Schema::table('plugins', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
            $table->json('features')->nullable()->after('description');
            $table->json('locations')->nullable()->after('features');
            $table->string('icon')->nullable()->after('locations');
        });
    }

    public function down(): void
    {
        Schema::table('plugins', function (Blueprint $table) {
            $table->dropColumn(['description', 'features', 'locations', 'icon']);
        });
    }
};
