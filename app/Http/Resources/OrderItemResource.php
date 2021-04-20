<?php

namespace App\Http\Resources;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */

    public function toArray($request)
    {
        //
    }

    public function getCustomerOrders()
    {
        return [
            'customer' => $this->name,
            'customer_email' => $this->email,
            'orders' => $this->getOrders(),
        ];
    }

    private function getOrders()
    {
        return collect($this->orders)->map(function ($order){
            return [
                'status' => $order['status'],
                'total' => $order['total'],
                'ordered_items' => $this->items()

            ];
        });
    }

    protected function items(){
        return collect($this->orderItems)->map(function ($order){
            return [
                'name' => Item::find($order['item_id'])->name,
                'price' => $order['price'],
                'quantity' => $order['qty'],
                'line_total' => $order['price'] * $order['qty']
                ];
        });
    }

//    protected function getStatus($status)
//    {
//        if ($this->status == 0) {
//            return "قيد التجهيز";
//        } elseif ($this->status == 1) {
//            return "تم تجهيز الطلب";
//        } elseif ($this->status == 2) {
//            return "تم تسليم الطلب";
//        }
//        return "الحالة غير صحيحة";
//    }


}
