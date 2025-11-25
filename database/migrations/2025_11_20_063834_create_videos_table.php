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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('video_url'); // YouTube/Vimeo ID or direct URL
            $table->string('thumbnail_url');
            $table->string('duration')->nullable(); // e.g. "12:34"
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->string('category')->default('general'); // behind_the_scenes, lookbook, interview
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
