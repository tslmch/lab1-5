<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Указываем, какие поля могут быть массово назначены
    protected $fillable = [
        'name',
        'cost',
        'amount',
    ];
    
}
