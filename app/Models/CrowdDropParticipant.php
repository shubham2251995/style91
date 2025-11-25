<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrowdDropParticipant extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function drop()
    {
        return $this->belongsTo(CrowdDrop::class, 'crowd_drop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
