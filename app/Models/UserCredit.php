<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCredit extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'presentations_remaining',
        'simulations_remaining',
        'reformulations_remaining'
    ];
    
    protected $casts = [
        'presentations_remaining' => 'integer',
        'simulations_remaining' => 'integer',
        'reformulations_remaining' => 'integer',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}