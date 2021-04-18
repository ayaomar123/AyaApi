<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemRequest;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Item;
use Illuminate\Http\Request;
use function request;

class CartItemController extends Controller
{
    public function index()
    {

        return CartResource::collection(auth()->user()->carts);
    }

    public function store(Request $request)
    {

        $cart = Cart::create([
            'user_id' => auth()->user()->id,
        ]);
        /*foreach (request('items') as $item){
            $price = (Item::find($item['item_id'])->special_price ??Item::find($item['item_id'])->price);
            CartItem::query()->create([
                'cart_id' => $cart->id,
                'item_id' => $item['item_id'],
                'qty' => $item['qty'],
                'line_total' => $price * $item['qty']
            ]);
        }*/

            $data = collect(request('items'))->map(function ($item) use ($cart){
                $price = (Item::find($item['item_id'])->special_price ??Item::find($item['item_id'])->price);
                return  CartItem::query()->create([
                    'cart_id' => $cart->id,
                    'item_id' => $item['item_id'],
                    'qty' => $item['qty'],
                    'user_id' => auth()->user()->id,
                    'line_total' => $price * $item['qty']
                ]);
            });
            $total = 0;
            foreach ($data as $datum){
                $total += $datum->line_total;
            }
             Cart::where('user_id', auth()->user()->id)
                ->update(['total_price' => $total]);
            return response()->json([
                'message' => 'Items Added To cart successfully',
                'data' => $data
            ], 200);


    }

    public function update(Request $request, $id)
    {

        $data = $request->all();
        if ($data){
            $item = CartItem::findOrFail($id);
            $price = (Item::find($item['item_id'])->special_price ??Item::find($item['item_id'])->price);

//            dd($item);
            $item->update($data);
            $item->update(['line_total' => $item->qty * $price]);
            $total = 0;
            $cart = CartItem::where('user_id',auth()->user()->id)->get();
            foreach ($cart as $datum){
                $total += $datum->line_total;
            }
            Cart::where('user_id', auth()->user()->id)
                ->update(['total_price' => $total]);
            return  response()->json([
                'message' => 'Item Updated success',
                'data' => $item
            ], 200);
        }
        return  response()->json([
            'message' => 'Please Choose at least one item to edit',
        ], 503);


    }

//remove items from cart
    public function destroy()
    {

//        dd(CartItem::where('user_id',auth()->user()->id));
        if (CartItem::find(request('item_id'))) {
            $item = CartItem::whereIn('item_id', request('item_id'))
                ->where('user_id',auth()->user()->id)
                ->delete();

            if ($item) {
                $total = 0;
                $data = CartItem::where('user_id',auth()->user()->id)->get();
                foreach ($data as $datum){
                    $total += $datum->line_total;
                }
                Cart::where('user_id', auth()->user()->id)
                    ->update(['total_price' => $total]);

                return response()->json([
                    'message' => 'Item removed successfully from cart!',
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
