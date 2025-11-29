<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_url',
        'avatar',
        'bio',
        'phone',
        'mobile',
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
        'referral_code',
        'role',
        'lifetime_spend',
        'membership_tier_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'onboarding_completed' => 'boolean',
            'onboarding_completed_at' => 'datetime',
            'onboarding_step' => 'integer',
            'profile_completion_percentage' => 'integer',
            'style_preferences' => 'array',
            'size_preferences' => 'array',
            'notification_preferences' => 'array',
            'loyalty_points' => 'integer',
            'achievements' => 'array',
            'profile_public' => 'boolean',
        ];
    }

    /**
     * Calculate and update profile completion percentage
     */
    public function updateProfileCompletion(): void
    {
        $fields = [
            'name' => 10,
            'email' => 10,
            'avatar' => 15,
            'bio' => 10,
            'phone' => 10,
            'date_of_birth' => 10,
            'gender' => 5,
            'style_preferences' => 15,
            'size_preferences' => 15,
        ];

        $total = 0;
        foreach ($fields as $field => $weight) {
            if (!empty($this->$field)) {
                $total += $weight;
            }
        }

        $this->update(['profile_completion_percentage' => $total]);
    }

    /**
     * Check if user needs onboarding
     */
    public function needsOnboarding(): bool
    {
        return !$this->onboarding_completed;
    }

    /**
     * Mark onboarding as complete
     */
    public function completeOnboarding(): void
    {
        $this->update([
            'onboarding_completed' => true,
            'onboarding_completed_at' => now(),
            'onboarding_step' => 4,
        ]);

        // Award points for completing onboarding
        $this->awardPoints(100, 'onboarding_complete');
    }

    /**
     * Award loyalty points
     */
    public function awardPoints(int $points, string $reason = null): void
    {
        $this->increment('loyalty_points', $points);

        // Track in achievements if significant
        if ($points >= 100) {
            $this->addAchievement([
                'type' => 'points_earned',
                'points' => $points,
                'reason' => $reason,
                'date' => now()->toDateTimeString(),
            ]);
        }
    }

    /**
     * Add achievement
     */
    public function addAchievement(array $achievement): void
    {
        $achievements = $this->achievements ?? [];
        $achievements[] = $achievement;
        $this->update(['achievements' => $achievements]);
    }

    /**
     * Get avatar URL with fallback
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        // Fallback to UI Avatars
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=4F46E5&color=fff&size=200';
    }
    public function influencer()
    {
        return $this->hasOne(Influencer::class);
    }

    public function membershipTier()
    {
        return $this->belongsTo(MembershipTier::class);
    }

    public function loyaltyPoints()
    {
        return $this->hasMany(LoyaltyPoint::class);
    }

    public function getLoyaltyBalanceAttribute()
    {
        return $this->loyaltyPoints()->sum('points');
    }

    // SEO Methods
    public function getSeoTitle()
    {
        return $this->name . ' | Member Profile';
    }

    public function getSeoDescription()
    {
        return 'Check out ' . $this->name . '\'s profile on Style91.';
    }
}
