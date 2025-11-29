<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Profile Information
            $table->string('avatar')->nullable()->after('email');
            $table->text('bio')->nullable()->after('avatar');
            $table->string('phone')->nullable()->after('bio');
            $table->date('date_of_birth')->nullable()->after('phone');
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->nullable()->after('date_of_birth');
            
            // Onboarding Tracking
            $table->boolean('onboarding_completed')->default(false)->after('gender');
            $table->timestamp('onboarding_completed_at')->nullable()->after('onboarding_completed');
            $table->integer('onboarding_step')->default(0)->after('onboarding_completed_at');
            $table->integer('profile_completion_percentage')->default(0)->after('onboarding_step');
            
            // User Preferences
            $table->json('style_preferences')->nullable()->after('profile_completion_percentage');
            $table->json('size_preferences')->nullable()->after('style_preferences');
            $table->json('notification_preferences')->nullable()->after('size_preferences');
            
            // Gamification
            $table->integer('loyalty_points')->default(0)->after('notification_preferences');
            $table->json('achievements')->nullable()->after('loyalty_points');
            
            // Social
            $table->boolean('profile_public')->default(false)->after('achievements');
            
            // Indexes
            $table->index('onboarding_completed');
            $table->index('profile_completion_percentage');
            $table->index('loyalty_points');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'bio',
                'phone',
                'date_of_birth',
                'gender',
                'onboarding_completed',
                'onboarding_completed_at',
                'onboarding_step',
                'profile_completion_percentage',
                'style_preferences',
                'size_preferences',
                'notification_preferences',
                'loyalty_points',
                'achievements',
                'profile_public',
            ]);
        });
    }
};
