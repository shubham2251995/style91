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
        if (!Schema::hasColumn('products', 'gender')) {
            Schema::table('products', function (Blueprint $table) {
                $table->enum('gender', ['Men', 'Women', 'Unisex'])->default('Unisex');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('products', 'gender')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('gender');
            });
        }
    }
};
