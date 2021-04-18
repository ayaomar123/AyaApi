<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = ItemResource::collection(Item::all());
        return  response()->json([
            'message' => 'success',
            'data' => $product
        ], 200);
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
    public function store()
    {
        try {
            $rules = (new ItemRequest())->rules();
            $message = (new ItemRequest())->messages();

            $validator = Validator::make(\request()->all(),$rules, $message);

            if ($validator->fails())
            {
                return  response()->json([
                    'message' => 'error',
                    'errors' => $validator->errors()->messages()
                ], 405);
            }

            $requestData = \request()->all();

            if( \request()->hasFile('image')){
                $image =  \request()->image->store('public/images');
                $imagename =  \request()->image->hashName();
                $requestData['image'] = $imagename;
            }

            $items = Item::create($requestData);

            $items->categories()->attach( \request()->category_id);

            return  response()->json([
                'message' => 'Items Created success',
                'data' => $items
            ], 200);
        } catch (\Exception $e) {
            return response()->error($e->getMessage());
        }

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
        $data = $request->all();
        if($data){
        $item = Item::findOrFail($id);
        $item->update($data);
            return  response()->json([
                'message' => 'Items Updated success',
                'data' => $item
            ], 200);
        }

        return  response()->json([
            'message' => 'Please Choose at least one item to edit',
//            'data' => $item
        ], 503);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        try {
            $item = Item::whereIn('id', \request('id'))
                ->delete();

            if ($item){
                return  response()->json([
                    'message' => 'Item Deleted successfully',
                ], 200);
            }
            else{
                return  response()->json([
                    'message' => 'Item Not Found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->error($e->getMessage());
        }
    }
}
