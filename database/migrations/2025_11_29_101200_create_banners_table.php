<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            
            // Type & Content
            $table->enum('type', ['drop', 'story', 'community', 'ar_preview', 'collab', 'hype', 'standard'])->default('standard');
            $table->string('title');
            $table->text('subtitle')->nullable();
            $table->text('description')->nullable();
            
            // Media (multi-format)
            $table->enum('media_type', ['image', 'video', 'gif', 'cinemagraph'])->default('image');
            $table->string('desktop_media_url', 500)->nullable();
            $table->string('mobile_media_url', 500)->nullable();
            $table->string('media_thumbnail', 500)->nullable();
            
            // Video specific
            $table->boolean('video_autoplay')->default(true);
            $table->boolean('video_loop')->default(true);
            $table->boolean('video_muted')->default(true);
            
            // Drop specific
            $table->dateTime('drop_date')->nullable();
            $table->integer('stock_count')->nullable();
            $table->boolean('notify_enabled')->default(false);
            
            // Social integration
            $table->string('instagram_hashtag', 100)->nullable();
            $table->string('tiktok_hashtag', 100)->nullable();
            $table->boolean('social_feed_enabled')->default(false);
            
            // AR/3D
            $table->boolean('ar_enabled')->default(false);
            $table->string('model_3d_url', 500)->nullable();
            
            // Hype features
            $table->boolean('show_view_count')->default(false);
            $table->boolean('show_purchase_ticker')->default(false);
            $table->boolean('show_stock_ticker')->default(false);
            
            // Styling
            $table->enum('text_position', ['left', 'center', 'right', 'bottom-left', 'bottom-center', 'bottom-right'])->default('center');
            $table->enum('overlay_type', ['gradient', 'solid', 'none', 'glitch', 'grain'])->default('gradient');
            $table->integer('overlay_opacity')->default(50);
            $table->string('background_color', 20)->nullable();
            $table->string('text_color', 20)->nullable();
            $table->string('accent_color', 20)->nullable();
            
            // Animation
            $table->enum('entrance_animation', ['fade', 'slide-up', 'slide-left', 'zoom', 'glitch', 'none'])->default('fade');
            $table->enum('scroll_effect', ['none', 'parallax', 'sticky', 'reveal'])->default('none');
            
            // CTA
            $table->string('cta_text', 100)->nullable();
            $table->string('cta_url', 500)->nullable();
            $table->enum('cta_style', ['primary', 'outline', 'minimal', 'glow'])->default('primary');
            
            // Badges/Labels
            $table->string('badge_text', 50)->nullable();
            $table->enum('badge_style', ['new', 'limited', 'sold-out', 'coming-soon', 'collab', 'custom'])->default('new');
            
            // Positioning
            $table->enum('position', ['hero', 'header-sticky', 'between-sections', 'footer', 'modal-popup'])->default('hero');
            $table->integer('display_priority')->default(0);
            
            // Visibility
            $table->boolean('is_active')->default(true);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->json('visibility_rules')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('type');
            $table->index('position');
            $table->index('is_active');
            $table->index('drop_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
