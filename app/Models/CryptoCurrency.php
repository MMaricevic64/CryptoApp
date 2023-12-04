<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoCurrency extends Model
{
    use HasFactory;
    protected $fillable = [
        'symbol', 
        'name',
        'price',
        'percent_change_15m',
        'update_enabled',
    ];
}
