<?php

namespace App\Http\Resources;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
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
        return [
//            'id' => $this->id,
            'status' =>$this->getStatus($this->status),
            'total' => $this->total,
            'order_item' => $this->myOrder(),
        ];
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
                'status' => $this->getStatus($order['status']),
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

    protected function getStatus($status)
    {
        if ($status == 0) {
            return "قيد التجهيز";
        }
        elseif ($status == 1) {
            return "تم تجهيز الطلب";
        }
            return "تم تسليم الطلب";

    }

    protected function myOrder(){
        return OrderItem::query()->where('customer_id',auth()->user()->id)->get();
    }


}
