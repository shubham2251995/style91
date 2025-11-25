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
        // Only rename if homepage_sections exists and sections doesn't
        if (Schema::hasTable('homepage_sections') && !Schema::hasTable('sections')) {
            Schema::rename('homepage_sections', 'sections');
        }

        // Add new columns if they don't exist
        if (Schema::hasTable('sections')) {
            Schema::table('sections', function (Blueprint $table) {
                if (!Schema::hasColumn('sections', 'page_id')) {
                    $table->foreignId('page_id')->nullable()->constrained()->nullOnDelete();
                }
                if (!Schema::hasColumn('sections', 'zone')) {
                    $table->string('zone')->default('main'); // main, sidebar, footer, etc.
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('sections')) {
            Schema::table('sections', function (Blueprint $table) {
                if (Schema::hasColumn('sections', 'page_id')) {
                    $table->dropForeign(['page_id']);
                    $table->dropColumn('page_id');
                }
                if (Schema::hasColumn('sections', 'zone')) {
                    $table->dropColumn('zone');
                }
            });

            // Only rename back if homepage_sections doesn't exist
            if (!Schema::hasTable('homepage_sections')) {
                Schema::rename('sections', 'homepage_sections');
            }
        }
    }
};
