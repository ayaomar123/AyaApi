<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(){
        return CartResource::collection(Cart::where('customer_id', auth()->user()->id)->get());
//        dd(CartResource::collection(Cart::where('user_id', 2)->get()));
    }
}
