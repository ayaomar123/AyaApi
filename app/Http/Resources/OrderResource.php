<?php

namespace App\Http\Resources;

use App\Models\Customer;
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
            'customer_name' => Customer::find($this->customer_id)->name,
            'customer_email' => Customer::find($this->customer_id)->email,
            'customer_mobile' => Customer::find($this->customer_id)->mobile,
            'status' => $this->getStatus(),
            'total' => $this->total,
        ];
    }

    protected function getStatus()
    {
        if ($this->status == 0) {
            return "قيد التجهيز";
        } elseif ($this->status == 1) {
            return "تم تجهيز الطلب";
        } elseif ($this->status == 2) {
            return "تم تسليم الطلب";
        }
        return "الحالة غير صحيحة";
    }
}
