<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banner_id')->constrained('banners')->onDelete('cascade');
            
            // Content
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->text('description')->nullable();
            
            // Media
            $table->enum('media_type', ['image', 'video', 'gif'])->default('image');
            $table->string('desktop_media_url', 500)->nullable();
            $table->string('mobile_media_url', 500)->nullable();
            $table->string('thumbnail_url', 500)->nullable();
            
            // Video
            $table->boolean('video_autoplay')->default(true);
            $table->integer('video_duration')->nullable();
            
            // Styling
            $table->enum('text_alignment', ['left', 'center', 'right'])->default('center');
            $table->string('text_color', 20)->nullable();
            $table->integer('overlay_opacity')->default(50);
            $table->text('custom_css')->nullable();
            
            // CTA
            $table->string('cta_text', 100)->nullable();
            $table->string('cta_url', 500)->nullable();
            
            // Order & Status
            $table->integer('slide_order')->default(0);
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // Indexes
            $table->index('banner_id');
            $table->index('slide_order');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
