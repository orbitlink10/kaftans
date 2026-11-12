<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['category_id', 'name', 'slug', 'description', 'base_price', 'unit_type', 'image', 'is_active'];

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function providers()
    {
        return $this->belongsToMany(Provider::class, 'provider_services');
    }
}
