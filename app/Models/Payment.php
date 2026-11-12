<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id', 'customer_id', 'phone_number', 'amount', 'checkout_request_id',
        'merchant_request_id', 'mpesa_receipt_number', 'status', 'callback_response',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'callback_response' => 'array',
        ];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
