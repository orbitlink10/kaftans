<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FashionProduct extends Model
{
    protected $guarded = ['id'];

    protected $casts = ['active' => 'boolean'];

    public function variants()
    {
        return $this->hasMany(FashionVariant::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(FashionCategory::class, 'subcategory_id');
    }
}
