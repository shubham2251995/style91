<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'full_name',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'zip_code',
        'country',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute()
    {
        $parts = [
            $this->address_line1,
            $this->address_line2,
            $this->city,
            $this->state,
            $this->zip_code,
            $this->country,
        ];

        return implode(', ', array_filter($parts));
    }

    public static function setAsDefault($userId, $addressId)
    {
        // Remove default from all addresses
        static::where('user_id', $userId)->update(['is_default' => false]);
        
        // Set new default
        static::where('id', $addressId)->update(['is_default' => true]);
    }
}
