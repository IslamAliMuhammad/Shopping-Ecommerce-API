<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::paginate(12);
        
        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'id' => 'nullable|numeric',
            'name' => 'required|string',
            'description' => 'required|string',
            'units' => 'required|numeric',
            'price' => 'required|numeric',
            'photo_path' => 'required|string',
        ]);
        
        $product = Product::create($validated);

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    
    public function show(Product $product) 
    {
        //

        return response()->json($product);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $product->update($request->only(['name', 'description', 'units', 'price', 'photo_path']));

        return response()->json(['message' => 'Product Updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();
        
        return response()->json(['message' => 'Product was deleted successfully'], 200);
    }
}
