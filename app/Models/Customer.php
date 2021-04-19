<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasFactory,HasApiTokens;
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'image'
    ];

    public function carts(){
        return $this->hasMany(Cart::class);
    }
    public function cartItems(){
        return $this->hasMany(CartItem::class);
    }
}
