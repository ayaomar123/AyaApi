<?php

namespace App\Http\Resources;

use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{

    public function getCustomerCarts()
    {
        return [
            'My_name' => $this->name,
            'total_cart_price' => Cart::where('customer_id',$this->id)->first()->total_price ?? "0",
            'my_cart_items' => $this->getCartItems(),
        ];
    }
    private function getCartItems()
    {
        return collect($this->cartItems)->map(function ($item){
            $price = Item::find($item['item_id'])->special_price ?? Item::find($item['item_id'])->price;
            return [
                'item' => Item::find($item['item_id'])->name,
                'quantity' => $item['qty'],
                'price' => $price,
                'line_total' => $item['qty'] * $price,


            ];
        });
    }



    public function toArray($request)
    {
        return [
            'item' =>$this->name ,
            'quantity' => $this->qty,
            'price' => Item::find($this->item_id)->special_price ?? Item::find($this->item_id)->price,
            'line_total' => $this->getTotal(),
        ];
    }
    protected function getTotal()
    {
        return
            $item_id_price = Item::find($this->item_id)->special_price ?? Item::find($this->item_id)->price * $this->qty;
    }
}
