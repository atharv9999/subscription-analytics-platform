<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    // Since we use UUIDs, we must tell Laravel not to expect an auto-incrementing integer
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'name', 'domain', 'status'];
}