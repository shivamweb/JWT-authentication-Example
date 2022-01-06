<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    public function create_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'name' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $product = Product::create([
            'image' => $request->image,
            'name' =>  $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return response()->json(compact('product'), 200);
    }

    public function fetch_product($id)
    {
        $data = "This data is open and can be accessed without the client being authenticated";
        return response()->json(compact('data'), 200);
    }

    public function product($id = null)
    {
        if ($id == null) {
            $data = Product::all();
            return response()->json(compact('data'), 200);
        } else {
            $data = Product::findOrFail($id);
            return response()->json(compact('data'), 200);
        }
    }

    public function update_product(Request $request)
    {
        if ($request->id == null) {
            return response()->json("Product ID is missing", 400);
        } else {
            $product = Product::findOrFail($request->id);
            $product->name = ($request->name == null ? $product->name : $request->name);
            $product->image = ($request->image == null ? $product->image : $request->image);
            $product->quantity = ($request->quantity == null ? $product->quantity : $request->quantity);
            $product->price = ($request->price == null ? $product->price : $request->price);
            $product->update();
            return response()->json(compact('product'), 200);
        }
    }
}