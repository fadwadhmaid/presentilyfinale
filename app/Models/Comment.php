<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['name', 'email', 'rating', 'comment', 'is_approved'];
    
    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
    ];
}