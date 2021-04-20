<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ItemResource;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CategoryResource::collection(
                Category::whereNull('parent_id')
                ->get()
        );
        return  response()->json([
            'message' => 'success',
            'data' => $categories
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
            $rules = (new CategoryRequest())->rules();
            $message = (new CategoryRequest())->messages();

            $validator = Validator::make(\request()->all(),$rules, $message);

            if ($validator->fails())
            {
                return  response()->json([
                    'message' => 'error',
                    'errors' => $validator->errors()->messages()
                ], 405);
            }

            $items = Category::create(\request()->all());
            return  response()->json([
                'message' => 'Items Created success',
                'data' => CategoryResource::collection(Category::where('id',$items->id)->get())
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
        if ($data){
            $item = Category::findOrFail($id);
            $item->update($data);
            return  response()->json([
                'message' => 'Item Updated success',
                'data' => CategoryResource::collection(Category::where('id',$item->id)->get())
            ], 200);
        }
        return  response()->json([
            'message' => 'Please Choose at least one item to edit',
        ], 503);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        try {
            $item = Category::whereIn('id', \request('id'))
                ->orWhere('parent_id', \request('id'))
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
