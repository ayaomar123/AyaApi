<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderResource;
use App\Models\Customer;
use App\Models\Order;

class CustomerOrderController extends Controller
{
    public function index(){
        return OrderItemResource::collection(Customer::query()->with('orders')->get())->map->getCustomerOrders();
    }

    public function changeOrderStatus(){
        $validated = \request()->validate([
            'status' => 'required|lte:2',
            'id' => 'required',
            'customer_id' => 'required',
        ]);
        if (count(Order::all())<=0)
            return response()->json([
                'message' => 'No Order Item Found!',
            ], 200);
        Order::where('customer_id', \request()->customer_id)->where('id',\request()->id)
            ->update(['status' => \request()->status]);
        return response()->json([
            'message' => 'Order Updated successfully',
            'data' => OrderResource::collection(Order::where('customer_id', \request()->customer_id)->get())
        ], 200);
    }


    public function getOrderByStatus(){

        return response()->json([
            'data' =>OrderResource::collection(Order::where('status',\request()->status)->get())
            ]);
    }
}
