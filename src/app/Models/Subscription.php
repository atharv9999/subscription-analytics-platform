<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'tenant_id', 'customer_id', 'plan_id', 'status',
     'current_period_start', 'current_period_end', 'canceled_at', 'metadata'];

    protected $casts = [
        'metadata' => 'array', // This is the magic line!
        'current_period_start' => 'datetime',
        'current_period_end' => 'datetime',
    ];
}
