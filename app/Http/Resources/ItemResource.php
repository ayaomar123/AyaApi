<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
//    public static $wrap = 'items';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'price' => $this->price,
            'special_price' => $this->special_price,
            'offer' => $this->offer == 1 ? $this->getOffer() : null,
            'quantity' => $this->quantity,
            'category' => $this->mergeWhen(!isset($this->category),
                $this->getCategory($this->categories)
            ),

        ];
    }

    private function getOffer(){
        return [
            'special_price_start' => $this->special_price_start,
            'special_price_end' => $this->special_price_end,
            'price_offer' => $this->price_offer
        ];
    }


    public function getCategory($category)
    {
        return collect($category)->map(function ($myCategory){
            return [
                'id' => $myCategory['id'],
                'name' => $myCategory['name'],
            ];
        });
    }

}
