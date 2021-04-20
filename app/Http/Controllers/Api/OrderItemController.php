<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cartItem = CartItem::where('customer_id',auth()->user()->id)->get();
        $orders = Order::create([
            'customer_id' => auth()->user()->id,
            'status' =>0
        ]);
        foreach ($cartItem as $item) {
            $price = (Item::find($item['item_id'])->special_price ?? Item::find($item['item_id'])->price);
            $myOrder = OrderItem::query()->create([
                'customer_id' => auth()->user()->id,
                'item_id' => $item->item_id,
                'qty' => $item->qty,
                'price' => $price,
                'order_id' => $orders->id,
                'line_total' => $price * $item->qty
            ]);
            CartItem::where('item_id', $item->item_id)
                ->where('customer_id', auth()->user()->id)
                ->delete();


            Cart::where('customer_id', auth()->user()->id)
                ->delete();
            $data = OrderItem::where('customer_id', auth()->user()->id)->where('order_id', $orders->id)->get();

            $total = 0;
            foreach ($data as $datum) {
                $total += $datum->line_total;
            }
            Order::where('customer_id', auth()->user()->id)
                ->update(['total' => $total]);


        }
        return response()->json([
            'message' => 'Items Ordered successfully',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if (OrderItem::find(request('item_id'))) {
            $item = OrderItem::whereIn('item_id', request('item_id'))
                ->where('customer_id',auth()->user()->id)
                ->delete();

            if ($item) {
                $total = 0;
                $data = OrderItem::where('customer_id',auth()->user()->id)->get();
                foreach ($data as $datum){
                    $total += $datum->line_total;
                }
                Order::where('customer_id', auth()->user()->id)
                    ->update(['total' => $total]);

                return response()->json([
                    'message' => 'Item removed successfully from order!',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Item Not Found',
                ], 404);
            }
        } else {
            return response()->json([
                'message' => 'Please chose at least one item to delete!',
            ], 403);
        }
    }
}
