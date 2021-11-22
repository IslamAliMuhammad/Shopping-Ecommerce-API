<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductColor;
use App\Models\Size;
use App\Models\CartItem;
use App\Models\ColorSize;

/**
 * @group cart_items
 */
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
        return response()->json(["cartItems" => CartItem::where('user_id', auth()->id())->with(['productColor.product', 'size'])->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @bodyParam quantity numeric required
     */
    public function store(Request $request)
    {
        //  

        $productColor = ProductColor::findOrFail($request->product_color_id);
        $size = Size::findOrFail($request->size_id);
        $colorSizePivotModel = ColorSize::colorSizeModel($productColor, $size);

        $request->validate([
            "product_color_id" => "required|numeric|exists:product_colors,id",
            "size_id" => ["required", "numeric", "exists:sizes,id"],
            "quantity" => "required|numeric|lte:$colorSizePivotModel->units"
        ]);
        
        // Attach to cart_item pivot
        auth()->user()->productColors()->attach($request->product_color_id, ['size_id' => $request->size_id, 'quantity' => $request->quantity]);
        
        return response()->json(["message" => "Successfully added to your cart!"], 200);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id for product details
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItem $cartItem)
    {
        //
        $cartItem->delete();

        return response()->json(['message' => 'Product successfully deleted from your cart!'], 200);
    }

}
