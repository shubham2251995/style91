<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftCard extends Model
{
    protected $fillable = [
        'code',
        'initial_value',
        'balance',
        'purchased_by',
        'recipient_email',
        'message',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'initial_value' => 'decimal:2',
        'balance' => 'decimal:2',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function purchaser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'purchased_by');
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isValid(): bool
    {
        return $this->is_active && !$this->isExpired() && $this->balance > 0;
    }

    public function getStatusAttribute(): string
    {
        if (!$this->is_active) return 'inactive';
        if ($this->isExpired()) return 'expired';
        if ($this->balance <= 0) return 'used';
        if ($this->balance < $this->initial_value) return 'partially_used';
        return 'active';
    }

    public static function generateCode(): string
    {
        do {
            $code = 'GC-' . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8));
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
