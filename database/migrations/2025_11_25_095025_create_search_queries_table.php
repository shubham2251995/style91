<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('search_queries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('query');
            $table->integer('results_count')->default(0);
            $table->timestamp('created_at');

            // Indexes for trending searches
            $table->index(['created_at', 'query']);
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('search_queries');
    }
};
