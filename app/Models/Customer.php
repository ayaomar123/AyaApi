<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{use HasApiTokens;
    use HasFactory,HasApiTokens;
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'image'
    ];

    public function cart(){
        return $this->hasOne(Cart::class);
    }

    public function cartItems(){
        return $this->hasMany(CartItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
