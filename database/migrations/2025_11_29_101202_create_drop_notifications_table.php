<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drop_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('banner_id')->constrained('banners')->onDelete('cascade');
            $table->string('user_email');
            $table->string('user_phone', 20)->nullable();
            $table->string('user_name', 100)->nullable();
            $table->boolean('notified')->default(false);
            $table->dateTime('notified_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('banner_id');
            $table->index('user_email');
            $table->index(['banner_id', 'notified']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drop_notifications');
    }
};
