<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'offer_id',
        'order_number',
        'status',
        'amount',
        'offer_details',
        'paid_at',
        'activated_at',
        'admin_notes'
    ];
    
    protected $casts = [
        'offer_details' => 'array',
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'activated_at' => 'datetime'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    
    // Générer numéro de commande unique
    public static function generateOrderNumber()
    {
        $prefix = 'PRES';
        $date = now()->format('Ymd');
        $lastOrder = self::whereDate('created_at', today())->count();
        $number = str_pad($lastOrder + 1, 3, '0', STR_PAD_LEFT);
        
        return "{$prefix}-{$date}-{$number}";
    }
}