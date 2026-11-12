<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingImage extends Model
{
    protected $fillable = ['booking_id', 'path'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
