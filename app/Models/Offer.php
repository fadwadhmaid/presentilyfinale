<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'period', 
        'features', 'is_active', 'sort_order'
    ];
    
    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}