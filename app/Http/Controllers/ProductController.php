<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

/**
 * @group products
 * 
 */
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     * @unauthenticated
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
        $this->authorize('create', Product::class);
        // Create product
        $productValidated = $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|numeric|exists:categories,id',
            'gender_id' => 'required|numeric|exists:genders,id',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'photo_path' => 'required|string',
        ]);     
        $product = Product::create($productValidated);

        // Create product_color
        $productColorValidated = Validator::make($request->colors, [
            '*.hex_code' => 'string',
        ])->validate();

        $productColors = $product->ProductColors()->createMany($productColorValidated);

        // Validate sizes with thier units
        $sizesValidated = Validator::make($request->colors, [
            '*.sizes' => 'required|array',
        ])->validate();

        // Validate sizes
        $sizesValidated = Validator::make($sizesValidated, [
            '*.sizes.*.size_id' => 'required|numeric',
            '*.sizes.*.units' => 'required|numeric'

        ])->validate();

        // Attach product_color with thier sizes & units
        foreach($productColors as $key => $productColor){
            $sizesPrepared = $this->prepareSizesToAttach(Arr::flatten($sizesValidated, 1)[$key]);
            $productColor->sizes()->attach($sizesPrepared);
        }

        return response()->json(["message" => "Product successfully created!", "product_id" => $product->id] , 201);
    }

    public function prepareSizesToAttach($producColorSizes){
        $sizesPrepared = [];
        foreach($producColorSizes as $productColorSize) {
            $sizesPrepared += [$productColorSize['size_id'] => ['units' => $productColorSize['units']]];
        }

        return $sizesPrepared;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     * 
     * @unauthenticated
     */
    
    public function show(Product $product) 
    {
        //

        $productColors = ProductColor::with('sizes')->where('product_id', $product->id)->get();

        return response()->json(['product' => $product, 'productColors' => $productColors], 200);
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
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'nullable|string',
            'category_id' => 'nullable|numeric|exists:categories,id',
            'gender_id' => 'nullable|numeric|exists:genders,id',
            'description' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'photo_path' => 'nullable|string',
        ]);

        $product->update($validated);
        return response()->json(['message' => 'Product successfully updated!'], 200);
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
        $this->authorize('delete',$product);

        $product->delete();
        
        return response()->json(['message' => 'Product successfully deleted!'], 200);
    }
}
