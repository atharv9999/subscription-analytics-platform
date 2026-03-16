<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UsageEvent extends Model
{
    use HasFactory;
    
    public $imcrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'tenant_id', 'subscription_id', 'type', 'quantity', 'event_time'];

    protected $casts = [
        'event_time' => 'datetime',
        'quantity'=> 'decimal:4'
    ];
}
