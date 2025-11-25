<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'payment_gateway_id',
        'transaction_id',
        'gateway_transaction_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'metadata',
        'failure_reason',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'paid_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function markAsCompleted($gatewayTransactionId = null, $metadata = [])
    {
        $this->update([
            'status' => 'completed',
            'gateway_transaction_id' => $gatewayTransactionId,
            'metadata' => array_merge($this->metadata ?? [], $metadata),
            'paid_at' => now(),
        ]);
    }

    public function markAsFailed($reason, $metadata = [])
    {
        $this->update([
            'status' => 'failed',
            'failure_reason' => $reason,
            'metadata' => array_merge($this->metadata ?? [], $metadata),
        ]);
    }
}
