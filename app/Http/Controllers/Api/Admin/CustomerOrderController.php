<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function index(){
        return OrderResource::collection(OrderItem::all());
    }

    public function changeOrderStatus(){
        Order::where('customer_id', \request()->customer_id)
            ->update(['status' => \request()->status]);
        return response()->json([
            'message' => 'Order Updated successfully',
        ], 200);
    }


    public function getOrderByStatus(){
        return Order::where('status',\request()->status)->get();
    }
}
