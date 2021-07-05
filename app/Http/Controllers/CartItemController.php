<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDetail;


class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json(["productDetails" => auth()->user()->productDetails], 200);
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
        $productDetail = ProductDetail::find($request->product_detail_id);
        $units = $productDetail->units;

        $validated = $request->validate([
            "product_detail_id" => "required|numeric|exists:product_details,id",
            "quantity" => "required|numeric|max:$units"
        ]);

        auth()->user()->productDetails()->attach($request->product_detail_id, ['quantity' => $request->quantity]);

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
     * @param  int  $id for product details
     * @return \Illuminate\Http\Response
     */
    public function destroy($productDetailId)
    {
        //
        auth()->user()->productDetails()->detach($productDetailId);
    }
}
