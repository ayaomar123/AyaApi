<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $table = 'cart_item';
    protected $fillable = [
        'cart_id',
        'item_id',
        'qty',
        'line_total',
        'user_id'
    ];

    public function carts(){
        return $this->belongsToMany(Cart::class);
    }
}
