<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banner_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banner_id')->constrained('banners')->onDelete('cascade');
            $table->date('date');
            $table->integer('impressions')->default(0);
            $table->integer('clicks')->default(0);
            $table->integer('shares')->default(0);
            $table->integer('video_plays')->default(0);
            $table->integer('avg_watch_time')->default(0); // in seconds
            $table->integer('drop_notifications')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index('banner_id');
            $table->index('date');
            $table->unique(['banner_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banner_analytics');
    }
};
