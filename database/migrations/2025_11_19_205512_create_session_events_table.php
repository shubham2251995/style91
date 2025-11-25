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
        Schema::create('session_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_session_id')->constrained()->onDelete('cascade');
            $table->string('event_type'); // page_view, click, add_to_cart, purchase, etc.
            $table->string('page_url')->nullable();
            $table->string('element_id')->nullable();
            $table->integer('x_position')->nullable();
            $table->integer('y_position')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_events');
    }
};
