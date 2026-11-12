<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_id', 'category_id', 'service_id', 'provider_id', 'booking_number',
        'location', 'preferred_date', 'preferred_time', 'description', 'urgency',
        'video_path', 'estimated_price', 'status', 'provider_status', 'assigned_at', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'preferred_date' => 'date',
            'assigned_at' => 'datetime',
            'completed_at' => 'datetime',
            'estimated_price' => 'decimal:2',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function images()
    {
        return $this->hasMany(BookingImage::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
