<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('preference_key');
            $table->text('preference_value')->nullable();
            $table->string('preference_type')->default('string'); // string, json, boolean, integer
            $table->timestamps();
            
            $table->unique(['user_id', 'preference_key']);
            $table->index('preference_key');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};
