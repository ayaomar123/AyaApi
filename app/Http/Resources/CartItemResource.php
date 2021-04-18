<?php

namespace App\Http\Resources;

use App\Models\Item;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'cart_id' => $this->cart_id,
            'item_id' => $this->item_id,
            'qty' => $this->qty,
            'price'=>Item::find($this->item_id)->special_price?? Item::find($this->item_id)->price,
            'line_total' => $this->getTotal(),
        ];
    }

    protected function getTotal(){
        return
            $item_id_price =( Item::find($this->item_id)->special_price?? Item::find($this->item_id)->price )* $this->qty ;
        //dd( $item_id_price);
    }
}
