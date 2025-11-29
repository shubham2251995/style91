<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DropNotification extends Model
{
    protected $fillable = [
        'banner_id', 'user_email', 'user_phone', 'user_name',
        'notified', 'notified_at',
    ];

    protected $casts = [
        'notified' => 'boolean',
        'notified_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function banner(): BelongsTo
    {
        return $this->belongsTo(Banner::class);
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('notified', false);
    }

    public function scopeNotified($query)
    {
        return $query->where('notified', true);
    }

    /**
     * Methods
     */
    public function markAsNotified(): void
    {
        $this->update([
            'notified' => true,
            'notified_at' => now(),
        ]);
    }
}
