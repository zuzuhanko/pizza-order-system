<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class carrier extends Model
{
    use HasFactory;
    protected $fillable = [
        'carrier_id',
        'name',
        'phone',
        'address',
        'gender',
    ];
}
