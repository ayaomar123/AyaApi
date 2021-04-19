<?php

namespace App\Http\Resources;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */

    public function toArray($request)
    {

            return [
                'customer_id' => $this->customer,
                'details' => $this->details(),

            ];
    }

    protected function details()
    {

        return [
            'item' =>Item::find($this->item_id)->name,
            'item_price' => Item::find($this->item_id)->special_price ?? Item::find($this->item_id)->price,
            'quantity' => $this->qty,
            'total_price' => $this->getTotal(),
        ];
    }

    protected function getTotal()
    {
        return
            $item_id_price = (Item::find($this->item_id)->special_price ?? Item::find($this->item_id)->price) * $this->qty;
    }
}
