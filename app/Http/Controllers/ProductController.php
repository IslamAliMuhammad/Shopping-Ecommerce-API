<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductDetail;

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
        // Validate and create product 
        $validator = Validator::make($request->product, [
            'name' => 'required|string',
            'category_id' => 'required|numeric|exists:categories,id',
            'gender_id' => 'required|numeric|exists:genders,id',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'photo_path' => 'required|string',
        ])->validate();

        $product = Product::create($validator);
        
        $productDetails = [];

        foreach($request->product_details as $productDetail){
            // Validate ad create product details for product was created
            $validator = Validator::make($productDetail, [
                'size' => 'required|string',
                'color' => 'required|string',
                'units' => 'required|numeric'
            ])->validate();

            $validator['product_id'] = $product->id;

            $productDetail = ProductDetail::create($validator);

            array_push($productDetails, $productDetail);
        }
       


        return response()->json(['product' => $product, 'product_details' => $productDetails], 201);
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
        return response()->json(['message' => 'Product successfully updated'], 200);
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
        
        return response()->json(['message' => 'Product successfully deleted'], 200);
    }
}
