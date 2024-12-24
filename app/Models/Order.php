<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // Указываем, какие поля могут быть массово назначены
    protected $fillable = [
        'name',
        'cost',
        'amount',
        'total_amount',
        'user_id',
        'status',  // Добавляем user_id в список массово присваиваемых полей
    ];

    // Связь с моделью User (каждый заказ принадлежит одному пользователю)
    public function user()
    {
        return $this->belongsTo(User::class);  // Связь с моделью User
    }

    public function getUserEmailAttribute()
    {
        return $this->user ? $this->user->email : null;
    }
}

